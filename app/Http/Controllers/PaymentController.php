<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\User;
use App\Models\CoachingSession;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
       $request->validate([
    'phone' => ['required', 'string', 'regex:/^(\+254|0)[0-9]{9}$/'],
    'amount' => 'required|numeric|min:1',
    'bookable_id' => 'required|integer',
    'bookable_type' => 'required|string',
]);


        $session = CoachingSession::find($request->bookable_id);
        if (!$session) {
            Log::error('Coaching session not found', ['bookable_id' => $request->bookable_id]);
            return back()->with('error', 'Coaching session not found');
        }

        // Normalize phone to 2547XXXXXXXX
        $phone = preg_replace('/^0/', '254', $request->phone);
        $phone = preg_replace('/^\+254/', '254', $phone);
        $phone = preg_replace('/\D/', '', $phone);

        // Validate number format (must be Safaricom 2547XXXXXXXX or Airtel 2541XXXXXXXX)
        if (strlen($phone) !== 12 || !in_array(substr($phone, 0, 4), ['2547', '2541'])) {
            Log::error('Invalid phone number format', ['phone' => $phone]);
            return back()->with('error', 'Invalid phone number format.');
        }

        $amount = (int) $request->amount;

        // Select base URL based on environment
        $baseUrl = env('MPESA_ENV') === 'production'
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';

        $accessToken = $this->getAccessToken($baseUrl);
        if (!$accessToken) {
            Log::error('Failed to get M-Pesa access token');
            return back()->with('error', 'Unable to connect to M-Pesa. Please try again later.');
        }

        $shortcode = env('MPESA_SHORTCODE', '174379');
        $passkey = env('MPESA_PASSKEY');
        $timestamp = date('YmdHis');
        $password = base64_encode($shortcode . $passkey . $timestamp);
        $callbackUrl = env('MPESA_CALLBACK_URL', route('mpesa.callback'));

        $payload = [
            "BusinessShortCode" => $shortcode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $amount,
            "PartyA" => $phone,
            "PartyB" => $shortcode,
            "PhoneNumber" => $phone,
            "CallBackURL" => $callbackUrl,
            "AccountReference" => "BookingPayment_" . Auth::id(),
            "TransactionDesc" => "Payment for coaching session",
        ];

        Log::info('STK Push payload', $payload);

        $ch = curl_init($baseUrl . '/mpesa/stkpush/v1/processrequest');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if ($response === false) {
            $error = curl_error($ch);
            Log::error('cURL error in STK Push', ['error' => $error, 'payload' => $payload]);
            curl_close($ch);
            return back()->with('error', 'Failed to initiate payment: Network error.');
        }
        curl_close($ch);

        $responseData = json_decode($response, true);
        Log::info('STK Push response', $responseData);

        if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == '0') {
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'amount' => $amount,
                'status' => 'pending',
                'phone_number' => $phone,
                'coaching_session_id' => $session->id,
                'mpesa_request_id' => $responseData['CheckoutRequestID'] ?? null,
            ]);

            $msg = env('MPESA_ENV') === 'sandbox'
                ? 'STK Push initiated (Sandbox). Use M-Pesa Daraja Simulator to complete.'
                : 'STK Push sent. Check your phone to complete payment.';

            return redirect()->route('payment.status', $payment)->with('success', $msg);
        }

        Log::error('STK Push failed', ['response' => $responseData]);
        return back()->with('error', 'Failed to initiate payment: ' . ($responseData['errorMessage'] ?? 'Unknown error'));
    }
  public function status(Payment $payment)
{
    if ($payment->user_id !== Auth::id()) {
        Log::error('Unauthorized access to payment status', ['payment_id' => $payment->id, 'user_id' => Auth::id()]);
        abort(403);
    }

    if ($payment->status === 'completed') {
        $coachingSession = CoachingSession::find($payment->coaching_session_id);
        if (!$coachingSession) {
            Log::error('Coaching session not found for completed payment', ['payment_id' => $payment->id]);
            return redirect()->route('dashboard')->with('error', 'Coaching session not found');
        }

        $booking = Booking::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'bookable_id' => $payment->coaching_session_id,
                'bookable_type' => CoachingSession::class,
            ],
            [
                'status' => 'confirmed',
                'full_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'participated' => false,
                'question' => null,
            ]
        );

        if ($booking->wasRecentlyCreated) {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'booking',
                    'message' => "New booking by " . Auth::user()->name,
                    'is_read' => false,
                ]);
            }
        }

        // Return the payment status view with a success message instead of redirecting immediately
        return view('payment.status', [
            'payment' => $payment,
            'success' => 'Payment was successful and booking confirmed!',
        ]);
    }

    return view('payment.status', compact('payment'));
}
   public function callback(Request $request)
{
    try {
        $content = $request->getContent();
        Log::info('M-Pesa callback raw', ['body' => $content]);

        // Check for empty payload
        if (empty($content)) {
            Log::error('Empty callback payload received');
            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Empty payload'], 200);
        }

        // Decode JSON
        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Invalid JSON in M-Pesa callback', [
                'error' => json_last_error_msg(),
                'body' => $content,
            ]);
            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Invalid JSON payload'], 200);
        }

        // Validate callback structure
        if (!isset($data['Body']['stkCallback'])) {
            Log::error('Invalid M-Pesa callback payload', ['payload' => $data]);
            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Invalid payload'], 200);
        }

        $callback = $data['Body']['stkCallback'];
        $checkoutRequestID = $callback['CheckoutRequestID'] ?? null;
        $resultCode = $callback['ResultCode'] ?? null;
        $resultDesc = $callback['ResultDesc'] ?? 'No description';

        Log::info('Callback details', [
            'CheckoutRequestID' => $checkoutRequestID,
            'ResultCode' => $resultCode,
            'ResultDesc' => $resultDesc,
        ]);

        if (empty($checkoutRequestID)) {
            Log::error('Missing CheckoutRequestID in M-Pesa callback', ['callback' => $callback]);
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted'], 200);
        }

        // Query payment
        $payment = Payment::where('mpesa_request_id', $checkoutRequestID)->first();
        if (!$payment) {
            Log::error('Payment not found for CheckoutRequestID', ['CheckoutRequestID' => $checkoutRequestID]);
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted'], 200);
        }

        // Handle successful payment
        if ($resultCode === 0) {
            if (!isset($callback['CallbackMetadata']['Item']) || !is_array($callback['CallbackMetadata']['Item'])) {
                Log::error('Invalid or missing CallbackMetadata', ['callback' => $callback]);
                $payment->update(['status' => 'failed']);
                return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Missing or invalid CallbackMetadata'], 200);
            }

            $items = collect($callback['CallbackMetadata']['Item']);
            $receiptItem = $items->firstWhere('Name', 'MpesaReceiptNumber');
            $receipt = $receiptItem['Value'] ?? null;

            if (!$receipt) {
                Log::error('MpesaReceiptNumber missing in CallbackMetadata', ['callback' => $callback]);
                $payment->update(['status' => 'failed']);
                return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Missing MpesaReceiptNumber'], 200);
            }

            // Update payment
            $payment->update([
                'status' => 'completed',
                'transaction_id' => $receipt,
                'mpesa_receipt_number' => $receipt,
            ]);

            Log::info('Payment completed', [
                'payment_id' => $payment->id,
                'receipt' => $receipt,
            ]);
        } else {
            // Handle failed payment
            $payment->update(['status' => 'failed']);
            Log::error('Payment failed', [
                'payment_id' => $payment->id,
                'result_code' => $resultCode,
                'result_desc' => $resultDesc,
            ]);

            // Notify user of failure (optional)
            Notification::create([
                'user_id' => $payment->user_id,
                'type' => 'payment',
                'message' => "Payment failed: $resultDesc",
                'is_read' => false,
            ]);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted'], 200);

    } catch (\Throwable $e) {
        Log::error('Exception in M-Pesa callback', [
            'exception' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'payload' => $request->getContent(),
        ]);
        return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Internal server error'], 500);
    }
}


    private function getAccessToken($baseUrl)
    {
        $consumerKey = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');
        $url = $baseUrl . '/oauth/v1/generate?grant_type=client_credentials';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode($consumerKey . ':' . $consumerSecret)
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if ($response === false) {
            Log::error('cURL error in getAccessToken', ['error' => curl_error($ch)]);
            curl_close($ch);
            return null;
        }

        curl_close($ch);
        $data = json_decode($response);
        $accessToken = $data->access_token ?? null;

        if (!$accessToken) {
            Log::error('Failed to retrieve M-Pesa access token', ['response' => $response]);
        }

        return $accessToken;
    }

    public function checkStatus(Payment $payment)
{
    // Only the owner can check
    if ($payment->user_id !== Auth::id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    return response()->json([
        'status' => $payment->status
    ]);
}

}