<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global middleware (berlaku untuk semua route).
     */
    protected $middleware = [];

    /**
     * Middleware groups untuk route "web" dan "api".
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\ShareChatList::class,
        ],
    ];

    /**
     * Route middleware (bisa dipanggil per-route).
     */
    protected $routeMiddleware = [];
}
