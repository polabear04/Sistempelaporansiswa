<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Chat;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View::composer('*', function ($view) {
        //     $user = Auth::user();

        //     if ($user && in_array($user->role, ['guru', 'murid'])) {
        //         $chats = $user->role === 'guru'
        //             ? Chat::with('murid')->where('guru_id', $user->id)->get()
        //             : Chat::with('guru')->where('murid_id', $user->id)->get();
        //     } else {
        //         $chats = collect();
        //     }

        //     $view->with('chats', $chats);
        // });
    }
}
