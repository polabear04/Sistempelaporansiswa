<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    protected function redirectTo($request): ?string
    {
        // Langsung tampilkan 404 kalau belum login
        if (! $request->expectsJson()) {
            abort(404);
        }

        return null; // fallback, tidak penting karena sudah abort
    }
}
