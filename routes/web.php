<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('login');
    Route::post('/', [MainController::class, 'login']);
});
Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::get('/akunGuru', [UsersController::class, 'akunGuru'])->name('akunGuru');
    Route::delete('/akunGuru/{id}', [UsersController::class, 'destroy'])->name('akun.deleteGuru');

    Route::get('/akunMurid', [UsersController::class, 'akunMurid'])->name('akunMurid');
    Route::delete('/akunMurid/{id}', [UsersController::class, 'destroy'])->name('akun.deleteMurid');

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
});
