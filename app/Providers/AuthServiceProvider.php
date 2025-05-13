<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */

    public function boot()
    {

        // Definisikan Gate untuk role admin
        Gate::define('admin-only', function ($user) {
            return $user->role === 'admin';
        });

        // Kamu bisa menambahkan gate lainnya jika diperlukan
        Gate::define('guru-only', function ($user) {
            return $user->role === 'guru';
        });
    }
}
