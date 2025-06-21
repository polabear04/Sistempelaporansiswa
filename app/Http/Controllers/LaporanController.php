<?php

namespace App\Http\Controllers;

use Cloudinary\Cloudinary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Laporan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function showDraft(Request $request)
    {
        $laporan = Laporan::with('user');

        // Role logic
        if (Auth::user()->is_admin) {
            // Admin: semua laporan
        } elseif (Auth::user()->role === 'guru') {
            $laporan = $laporan->whereIn('status', ['diterima', 'ditolak']);
        } else {
            $laporan = $laporan->where('user_id', Auth::id());
        }

        // 🔍 Filter search gabungan:
        if ($request->filled('search')) {
            $search = $request->input('search');

            $laporan = $laporan->where(function ($q) use ($search) {
                // cari nama di tabel laporan
                $q->where('nama', 'like', '%' . $search . '%')
                    // cari NIS di relasi user
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('NIS', 'like', '%' . $search . '%');
                    });
            });
        }

        // 🗓 Filter tanggal
        if ($request->filled('filter_date')) {
            $filter = $request->input('filter_date');

            if ($filter == 'today') {
                $laporan = $laporan->whereDate('created_at', Carbon::today());
            } elseif ($filter == 'yesterday') {
                $laporan = $laporan->whereDate('created_at', Carbon::yesterday());
            } elseif ($filter == 'last_7_days') {
                $laporan = $laporan->whereDate('created_at', '>=', Carbon::now()->subDays(7));
            }
        }

        $laporan = $laporan->latest()->paginate(10);

        return view('dashboard.draft', compact('laporan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $last = Laporan::orderBy('id_laporan', 'desc')->first();
        $newNumber = $last ? ((int) Str::after($last->id_laporan, 'LP-') + 1) : 1;
        $newId = 'LP-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);


        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => 'dgfq5rcdb',
                'api_key'    => '875336276435697',
                'api_secret' => 'wsaEfEizLM_QDhcVS9hN2LbPyLs',
            ],
            'url' => [
                'secure' => true
            ],
        ]);


        $uploadResult = $cloudinary->uploadApi()->upload($request->file('foto')->getRealPath());
        $fotoUrl = $uploadResult['secure_url'];


        Laporan::create([
            'id_laporan' => $newId,
            'nama'       => $request->nama,
            'deskripsi'  => $request->deskripsi,
            'tanggal'    => $request->tanggal,
            'status'     => $request->status ?? 'pending',
            'user_id'    => Auth::id(),
            'foto'       => $fotoUrl,
        ]);

        return redirect()->route('draft')->with('success', 'Laporan berhasil ditambahkan!');
    }



    public function destroy($id)
    {
        $laporan = Laporan::where('id_laporan', $id)->firstOrFail();

        if ($laporan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus laporan ini.');
        }

        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
    public function approve($id)
    {
        Laporan::where('id_laporan', $id)->update(['status' => 'diterima']);

        $laporan = Laporan::where('id_laporan', $id)->firstOrFail();

        $existingChat = Chat::where('id_laporan', $id)->first();

        if (!$existingChat) {
            Chat::create([
                'guru_id' => Auth::id(),
                'murid_id' => $laporan->user_id,
                'id_laporan' => $id,
            ]);
        }

        return back()->with('success', 'Laporan diterima dan chat telah dibuat.');
    }


    public function reject($id)
    {
        Laporan::where('id_laporan', $id)->update(['status' => 'ditolak']);
        return back()->with('success', 'Laporan ditolak.');
    }
    public function showPenerimaan()
    {

        $laporan = Laporan::where('status', 'pending')->get();

        return view('dashboard.penerimaan', compact('laporan'));
    }
}
