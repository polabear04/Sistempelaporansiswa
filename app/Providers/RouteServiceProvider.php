<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use App\Http\Middleware\CheckRole;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Daftarkan alias middleware 'checkrole'
        app(Router::class)->aliasMiddleware('checkrole', CheckRole::class);

        // Web routes
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
