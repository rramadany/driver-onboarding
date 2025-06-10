<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
    ];

    public function boot(): void
    {
        Gate::define('manage-users', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('approve-drivers', function (User $user) {
            return $user->role === 'supervisor';
        });

        Gate::define('manage-drivers', function (User $user) {
            return $user->role === 'hr';
        });
    }
}