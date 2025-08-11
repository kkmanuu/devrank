<?php

namespace App\Providers;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Policies\ContactMessagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ContactMessage::class => ContactMessagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        View::composer('layouts.navigation', function ($view) {
    $unreadNotificationsCount = 0;

    if (Auth::check()) {
        $unreadNotificationsCount = Auth::user()->unreadNotifications->count();
    }

    $view->with('unreadNotificationsCount', $unreadNotificationsCount);
});

    }
}
