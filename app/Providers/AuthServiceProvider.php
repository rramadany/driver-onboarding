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
        Gate::define('manage-drivers', function (User $user) {
            return in_array($user->role, ['hr', 'supervisor', 'admin']);
        });

        Gate::define('approve-drivers', function (User $user) {
            return in_array($user->role, ['supervisor', 'admin']);
        });

        Gate::define('manage-users', function (User $user) {
            return $user->role === 'admin';
        });
    }
}