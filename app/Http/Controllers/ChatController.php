<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Tampilkan daftar chat user (guru/murid)
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil data awal berdasarkan role
        if ($user->role == 'guru') {
            $chats = Chat::with('murid')
                ->where('guru_id', $user->id);
        } elseif ($user->role == 'murid') {
            $chats = Chat::with('guru')
                ->where('murid_id', $user->id);
        } else {
            $chats = collect(); // kosong jika admin atau role lain
            return view('dashboard.chat', compact('chats'));
        }

        // 🔍 Filter Search berdasarkan nama relasi user
        if ($request->filled('search')) {
            $search = $request->input('search');

            $chats = $chats->whereHas($user->role == 'guru' ? 'murid' : 'guru', function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            });
        }

        //  Filter berdasarkan tanggal created_at di tabel Chat
        if ($request->filled('filter_date')) {
            $filter = $request->input('filter_date');

            if ($filter == 'today') {
                $chats = $chats->whereDate('created_at', Carbon::today());
            } elseif ($filter == 'yesterday') {
                $chats = $chats->whereDate('created_at', Carbon::yesterday());
            } elseif ($filter == 'last_7_days') {
                $chats = $chats->whereDate('created_at', '>=', Carbon::now()->subDays(7));
            }
        }

        $chats = $chats->latest()->paginate(10);

        return view('dashboard.chat', compact('chats'));
    }

    // Tampilkan chat dan pesan-pesannya
    public function show(Chat $chat)
    {
        // Pastikan user berhak akses chat ini
        $user = Auth::user();
        if ($user->role == 'guru' && $chat->guru_id != $user->id) abort(403);
        if ($user->role == 'murid' && $chat->murid_id != $user->id) abort(403);

        $chat->load(['messages.sender', 'guru', 'murid']);

        return view('dashboard.show', compact('chat'));
    }

    // Kirim pesan baru
    public function sendMessage(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Pastikan user berhak kirim pesan di chat ini
        $user = Auth::user();
        if ($user->role == 'guru' && $chat->guru_id != $user->id) abort(403);
        if ($user->role == 'murid' && $chat->murid_id != $user->id) abort(403);

        $chat->messages()->create([
            'sender_id' => $user->id,
            'message' => $request->message,
        ]);

        return redirect()->route('chats.show', $chat->id);
    }
}
