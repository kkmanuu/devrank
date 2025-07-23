<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    HomeController,
    DashboardController,
    ProjectController,
    PaymentController,
    EventController,
    CoachingController,
    AdminController,
    MessageController,
    ProfileController
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

// Authenticated (students & admins)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/submit-project', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/submit-project', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/submissions/{submission}', [ProjectController::class, 'show'])->name('submission.show');

    // ✅ One version of events routes, handled by EventController logic
    Route::get('/events', [EventController::class, 'index'])->name('events.index'); Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/book', [EventController::class, 'book'])->name('events.book');

    Route::get('/coaching', [CoachingController::class, 'index'])->name('coaching.index');

    Route::post('/coaching/{session}/book', [CoachingController::class, 'book'])->name('coaching.book');

    Route::post('/payment', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/payment/required', function () {
        return view('payment.required');
    })->name('payment.required');

    Route::post('/message', [MessageController::class, 'store'])->name('message.store');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
});

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('dashboard');

    Route::get('/submissions', [DashboardController::class, 'manageSubmissions'])->name('submissions');
    Route::get('/users', [DashboardController::class, 'manageUsers'])->name('users');
    Route::get('/payments', [DashboardController::class, 'managePayments'])->name('payments');
    Route::get('/messages', [DashboardController::class, 'manageMessages'])->name('messages');
    Route::post('/submissions/{submission}/review', [AdminController::class, 'review'])->name('review');
    Route::post('/messages/{message}/respond', [MessageController::class, 'respond'])->name('messages.respond');

    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('users.create');
Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('users.store');

     Route::get('/coaching/create', [CoachingController::class, 'create'])->name('coaching.create');
    
    Route::post('/coaching', [CoachingController::class, 'store'])->name('coaching.store');
    Route::get('/admin/coaching', [CoachingController::class, 'index'])->name('coaching.index');
   
});

// M-PESA callback route
Route::post('/mpesa/callback', [PaymentController::class, 'callback'])->name('mpesa.callback');

// Auth scaffolding (login/register/etc.)
require __DIR__.'/auth.php';
