<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function showDraft()
    {
        $laporan = null;

        if (Auth::user()->is_admin) {
            // Admin melihat semua laporan tanpa filter
            $laporan = Laporan::with('user')->get();
        } elseif (Auth::user()->role === 'guru') {
            // Guru hanya melihat laporan yang diajukan oleh murid dengan status diterima atau ditolak
            $laporan = Laporan::with('user')
                ->whereIn('status', ['diterima', 'ditolak']) // Filter status diterima dan ditolak
                ->whereHas('user', function ($query) {
                    // Pastikan laporan hanya untuk murid
                    $query->where('role', 'murid');
                })
                ->get();
        } else {
            // Murid hanya bisa melihat laporan yang mereka ajukan
            $laporan = Laporan::with('user')
                ->where('user_id', Auth::id()) // Hanya laporan yang diajukan oleh murid yang sedang login
                ->get();
        }

        return view('dashboard.draft', compact('laporan'));
    }


    public function store(Request $request)
    {
        $last = Laporan::orderBy('id_laporan', 'desc')->first();

        if ($last) {
            $lastNumber = (int) Str::after($last->id_laporan, 'LP-');
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $newId = 'LP-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        Laporan::create([
            'id_laporan' => $newId,
            'nama'       => $request->nama,
            'deskripsi'  => $request->deskripsi,
            'tanggal'    => $request->tanggal,
            'status'     => $request->status ?? 'pending',
            'user_id'    => Auth::id(),
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
        return back()->with('success', 'Laporan diterima.');
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
