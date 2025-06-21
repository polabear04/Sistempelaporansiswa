<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // Data default
        $totalUsers = null;
        $totalVerifiedUsers = null;
        $laporanDiajukan = null;
        $laporanDisetujui = null;
        $laporanSaya = null;
        $laporanSayaDisetujui = null;

        if ($role == 'admin') {
            $totalUsers = User::count();
            $totalVerifiedUsers = User::whereNotNull('email_verified_at')->count();
        } elseif ($role == 'guru') {
            $laporanDiajukan = Laporan::where('status', 'pending')->count(); // Semua laporan yang diajukan
            $laporanDisetujui = Laporan::whereIn('status', ['diterima', 'ditolak'])->count(); // Status disetujui
        } elseif ($role == 'murid') {
            $laporanSaya = Laporan::where('user_id', Auth::id())->count(); // Laporan milik murid
            $laporanSayaDisetujui = Laporan::where('user_id', Auth::id())
                ->where('status', 'diterima')->count(); // Laporan milik murid yang disetujui
        }

        return view('dashboard.index', compact(
            'totalUsers',
            'totalVerifiedUsers',
            'laporanDiajukan',
            'laporanDisetujui',
            'laporanSaya',
            'laporanSayaDisetujui'
        ));
    }

    public function pelaporan()
    {
        return view('dashboard.pelaporan');
    }
    public function pengajuan()
    {
        return view('dashboard.pengajuan');
    }
    public function draft()
    {
        return view('dashboard.draft');
    }
    public function boot()
    {
        view()->share('totalUsers', \App\Models\User::count());
    }
    public function allAkun(Request $request)
    {
        $query = User::query();

        // Search by nama / NIS / role
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('NIS', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan role (admin/guru/murid)
        $filterRole = $request->input('filter_role');
        if ($filterRole != '') {
            $query->where('role', $filterRole);
        }
        // Ambil hasil
        $users = $query->latest()->paginate(10);

        return view('dashboard.akun', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'NIS' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|in:admin,guru,siswa',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        $user->NIS = $request->NIS;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('akun')->with('success', 'User berhasil dihapus.');
    }
    public function addAkun(Request $request)
    {

        try {
            $user = new User();
            $user->NIS = $request->input('NIS');
            $user->nama = $request->input('nama');
            $user->alamat = $request->input('alamat');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->role = $request->input('role');

            // Cek apakah file diupload
            if ($request->hasFile('file')) {
                $user->foto_profile = $request->file('file')->getClientOriginalName();
                $request->file('file')->move('img/', $user->foto_profile);
            }

            $user->save();

            return redirect()->back()->with('success', 'Akun baru berhasil ditambahkan');
        } catch (\Exception $e) {
            // Log error agar bisa dicek developer
            Log::error('Gagal menambahkan akun: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Gagal menambahkan akun');
        }
    }


    public function akunGuru()
    {
        if (Gate::denies('admin-only')) {
            // Jika tidak, tampilkan halaman error (403)
            abort(403, 'Akses ditolak. Hanya admin yang bisa mengakses halaman ini.');
        }
        $users = User::where('role', 'guru')->get();
        return view('dashboard.akunGuru', compact('users'));
    }
    public function destroyGuru($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('akunGuru')->with('success', 'User berhasil dihapus.');
    }

    public function akunMurid()
    {
        $users = User::where('role', 'murid')->get();
        return view('dashboard.akunMurid', compact('users'));
    }
    public function destroyMurid($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('akunMurid')->with('success', 'User berhasil dihapus.');
    }
    public function profile()
    {
        return view('dashboard.profile');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id()), // agar email sendiri tidak dianggap bentrok
            ],
            'alamat' => 'required|string|max:255',
        ]);

        $user = User::find(Auth::id());

        if ($user) {
            $changes = [];

            if ($user->nama !== $request->nama) {
                $user->nama = $request->nama;
                $changes[] = 'Nama';
            }

            if ($user->email !== $request->email) {
                $user->email = $request->email;
                $changes[] = 'Email';
            }

            if ($user->alamat !== $request->alamat) {
                $user->alamat = $request->alamat;
                $changes[] = 'Alamat';
            }

            if (count($changes) > 0) {
                $user->save();
                return redirect()->back()->with('success', implode(', ', $changes) . ' berhasil diperbarui.');
            } else {
                return redirect()->back()->with('info', 'Tidak ada perubahan yang dilakukan.');
            }
        }

        return redirect()->route('login')->with('error', 'Pengguna tidak ditemukan.');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session dan regenerate token agar lebih aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    public function ubahPassword()
    {
        return view('dashboard/ubahPassword');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }
}
