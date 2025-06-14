<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\NewPasswordController;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('login');
    Route::post('/', [MainController::class, 'login']);

    Route::get('/lupa-password', function () {
        return view('lupaPassword');
    })->middleware('guest')->name('password.request');

    Route::post('/lupa-password', function (Illuminate\Http\Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    })->middleware('guest')->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.update');
});
Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::get('/akunGuru', [UsersController::class, 'akunGuru'])->name('akunGuru');
    Route::delete('/akunGuru/{id}', [UsersController::class, 'destroy'])->name('akun.deleteGuru');

    Route::get('/akunMurid', [UsersController::class, 'akunMurid'])->name('akunMurid');
    Route::delete('/akunMurid/{id}', [UsersController::class, 'destroy'])->name('akun.deleteMurid');

    Route::put('/akun/{user}', [UsersController::class, 'update'])->name('akun.update');
    Route::get('/akun', [UsersController::class, 'allAkun'])->name('akun');
    Route::post('/addAkun', [UsersController::class, 'addAkun'])->name('addAkun');
    Route::delete('/akun/{id}', [UsersController::class, 'destroy'])->name('akun.delete');
});
Route::middleware(['auth', 'checkrole:murid'])->group(function () {
    Route::get('/pengajuan', [UsersController::class, 'pengajuan']);
});
Route::middleware(['auth', 'checkrole:guru'])->group(function () {
    Route::post('/laporan/{id}/approve', [LaporanController::class, 'approve'])->name('laporan.approve');
    Route::post('/laporan/{id}/reject', [LaporanController::class, 'reject'])->name('laporan.reject');
    Route::get('/penerimaan', [LaporanController::class, 'showPenerimaan'])->name('laporan.penerimaan');
});
Route::middleware(['auth'])->group(function () {

    Route::get('/index', [UsersController::class, 'index'])->name('dashboard');


    Route::get('/pelaporan', [UsersController::class, 'pelaporan']);

    Route::get('/profile', [UsersController::class, 'profile']);
    Route::post('/profile/update', [UsersController::class, 'updateProfile'])->name('profile.update');

    Route::post('/logout', [UsersController::class, 'logout'])->name('logout');

    Route::get('/draft', [LaporanController::class, 'showDraft'])->name('draft')->middleware('auth');
    Route::post('/draft/store', [LaporanController::class, 'store'])->name('laporan.store');
    Route::delete('/draft/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');

    // Detail chat & pesan
    Route::get('/chats/{chat}', [ChatController::class, 'show'])->name('chats.show');

    // Kirim pesan baru di chat
    Route::post('/chats/{chat}/message', [ChatController::class, 'sendMessage'])->name('chats.message.send');
    // Kirim ulang link verifikasi email
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Link verifikasi telah dikirim!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    // Verifikasi via link email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/profile');
    })->middleware(['auth', 'signed'])->name('verification.verify');
    Route::get('/email/verify', function () {
        return redirect('/profile');
    })->middleware('auth')->name('verification.notice');


    Route::get('/laporan/{id}/cetak', [PDFController::class, 'cetakPDF'])->name('laporan.cetak');
});


Route::get('/fix-env', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return '✅ Laravel config dan cache berhasil dibersihkan.';
});

Route::get('/generate-test-link', function () {
    $link = URL::signedRoute('signed.test');
    return "<a href='$link'>Klik untuk uji signed URL</a><br><br>$link";
});

Route::get('/signed-test', function () {
    return '✅ Signature valid! Signed URL bekerja dengan baik.';
})->middleware('signed')->name('signed.test');
Route::get('/is-secure', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'isSecure' => $request->isSecure(),
        'url' => $request->fullUrl(),
        'x_forwarded_proto' => $request->header('X-Forwarded-Proto'),
    ]);
});
