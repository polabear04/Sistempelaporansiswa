<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Chat;

class ShareChatList
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && in_array($user->role, ['guru', 'murid'])) {
            $chats = $user->role === 'guru'
                ? Chat::with('murid')->where('guru_id', $user->id)->get()
                : Chat::with('guru')->where('murid_id', $user->id)->get();
        } else {
            $chats = collect();
        }

        View::share('chats', $chats);

        return $next($request);
    }
}
