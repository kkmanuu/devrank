<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    DashboardController,
    ProjectController,
    PaymentController,
    EventController,
    CoachingController,
    AdminController,
    MessageController,
    ProfileController,
    ServiceController,
    ContactMessageController,
    NotificationController
};

// Public pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Language switcher
Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sw'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('setLocale');

// Authenticated routes (students, admins, coaches)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/submit-project', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/submit-project', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/submissions/{submission}', [ProjectController::class, 'show'])->name('submission.show');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/book', [EventController::class, 'showBookingForm'])->name('events.bookForm');
    Route::post('/events/{event}/book', [EventController::class, 'processBooking'])->name('events.book');

    Route::get('/coaching', [CoachingController::class, 'index'])->name('coaching.index');
    Route::get('/coaching/{session}', [CoachingController::class, 'show'])->name('coaching.show');
    Route::get('/coaching/{session}/book', [CoachingController::class, 'showBookingForm'])->name('coaching.book.form');
    Route::post('/coaching/{session}/book', [CoachingController::class, 'book'])->name('coaching.book');

    Route::match(['get', 'post'], '/payment', [PaymentController::class, 'initiatePayment'])->name('payment');

    Route::get('/payment/required', fn () => view('payment.required'))->name('payment.required');
    Route::get('/payment/status/{payment}', [PaymentController::class, 'status'])->name('payment.status');
    Route::get('/payment/status/check/{payment}', [PaymentController::class, 'checkStatus'])->name('payment.status.check');

    Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');

      Route::get('submissions', [AdminController::class, 'submissions'])->name('admin.submissions');
    Route::get('submissions/{submission}/edit', [AdminController::class, 'editSubmission'])->name('admin.submissions.edit');
    Route::put('submissions/{submission}', [AdminController::class, 'updateSubmission'])->name('admin.submissions.update');
    Route::delete('submissions/{submission}', [AdminController::class, 'destroySubmission'])->name('admin.submissions.destroy');

    

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::patch('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

// Admin-only routes with proper prefix & name grouping
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('home');

    Route::delete('/coaching/{session}', [CoachingController::class, 'destroy'])->name('coaching.destroy');

    Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');

    Route::get('/submissions', [AdminController::class, 'submissions'])->name('submissions');
    Route::post('/submissions/{submission}/review', [AdminController::class, 'review'])->name('submissions.review');

    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/coaching', [CoachingController::class, 'index'])->name('coaching.index');
    Route::get('/coaching/create', [CoachingController::class, 'create'])->name('coaching.create');
    Route::post('/coaching', [CoachingController::class, 'store'])->name('coaching.store');
    Route::get('/coaching/{session}/edit', [CoachingController::class, 'edit'])->name('coaching.edit');
    Route::put('/coaching/{session}', [CoachingController::class, 'update'])->name('coaching.update');

    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

     Route::get('/contact-messages', [ContactMessageController::class, 'adminIndex'])->name('contact-messages.index');
    Route::get('/contact-messages/{contactMessage}/reply', [ContactMessageController::class, 'replyForm'])->name('contact-messages.replyForm');
    Route::post('/contact-messages/{contactMessage}/reply', [ContactMessageController::class, 'reply'])->name('contact-messages.reply');
    Route::patch('/contact-messages/{contactMessage}/mark-as-read', [ContactMessageController::class, 'markAsRead'])->name('contact-messages.markAsRead');
    Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::patch('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

// M-PESA callback route
Route::post('mpesa/callback', [PaymentController::class, 'callback'])->name('mpesa.callback');
Route::post('mpesa/validate', [PaymentController::class, 'validateMpesa'])->name('mpesa.validate');
Route::post('mpesa/confirm', [PaymentController::class, 'confirm'])->name('mpesa.confirm');
Route::post('mpesa/stk-push', [PaymentController::class, 'stkPush'])->name('mpesa.stkPush');
Route::post('mpesa/transaction-status', [PaymentController::class, 'transactionStatus'])->name('mpesa.transactionStatus');

require __DIR__ . '/auth.php';