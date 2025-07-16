<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CoachingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sw'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('setLocale');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');
    Route::get('/submit-project', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/submit-project', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/submissions/{submission}', [ProjectController::class, 'show'])->name('submission.show');

    Route::post('/book-coaching', [CoachingController::class, 'book'])->name('coaching.book');
    Route::get('/coaching', [CoachingController::class, 'index'])->name('coaching');
     Route::get('/events', [CoachingController::class, 'index'])->name('events.index');
    Route::post('/payment', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/payment/required', function () {
        return view('payment.required');
    })->name('payment.required');
    Route::post('/message', [MessageController::class, 'store'])->name('message.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/submissions', [DashboardController::class, 'manageSubmissions'])->name('admin.submissions');
    Route::get('/users', [DashboardController::class, 'manageUsers'])->name('admin.users');
    Route::get('/payments', [DashboardController::class, 'managePayments'])->name('admin.payments');
    Route::get('/messages', [DashboardController::class, 'manageMessages'])->name('admin.messages');
    Route::post('/submissions/{submission}/review', [AdminController::class, 'review'])->name('admin.review');
    Route::post('/messages/{message}/respond', [MessageController::class, 'respond'])->name('message.respond');
});

Route::post('/mpesa/callback', [PaymentController::class, 'callback'])->name('mpesa.callback');
?>