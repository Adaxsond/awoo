<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserRegisController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BidangKajianController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;

// Route default - arahkan ke halaman login
Route::get('/', function () {
    return view('login');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('login');
});

Route::post('/login-admin', [AdminLoginController::class, 'login'])->name('login.admin');

Route::get('/beranda', function () {
    // Get statistics for the dashboard
    $jumlahBuku = \App\Models\Buku::count();
    $jumlahAnggota = \App\Models\User::where('role', 1)->count();
    $jumlahPeminjaman = \App\Models\Peminjaman::where('status', 'dipinjam')->count();
    $jumlahSelesai = \App\Models\Peminjaman::where('status', 'selesai')->count();

    // Pass users if admin (role 0), or null for regular users (role 1)
    $users = Auth::user()->role == 0 ? \App\Models\User::latest()->paginate(10) : null;

    return view('beranda', compact('users', 'jumlahBuku', 'jumlahAnggota', 'jumlahPeminjaman', 'jumlahSelesai'));
})->middleware('auth')->name('beranda');

Route::get('/registrasi', [UserRegisController::class, 'registrasi'])->name('registrasi');
Route::post('/registrasi', [UserRegisController::class, 'store'])->name('registrasisimpan');

Route::get('/loginuser', [UserLoginController::class, 'loginuser'])->name('loginuser');
Route::post('/loginuser', [UserLoginController::class, 'proseslogin'])->name('proseslogin');

Route::get('/buku/tambah', [BukuController::class, 'create'])->name('tambahbuku');
Route::post('/buku/store', [BukuController::class, 'store'])->name('simpanbuku');
Route::get('/buku', [BukuController::class, 'index'])->name('indexbuku');
Route::get('/buku/kategori/{kategori}', [BukuController::class, 'byKategori'])->name('kategoribuku');
Route::get('/buku/bidang/{bidang}', [BukuController::class, 'byBidang'])->name('bidangbuku');
Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('editbuku');
Route::delete('/buku/{id}/destroy', [BukuController::class, 'destroy'])->name('hapusbuku');
Route::post('/buku/{id}/update', [BukuController::class, 'update'])->name('updatebuku');

Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggotaindex');
Route::get('/anggota/{id}', [AnggotaController::class, 'show'])->name('anggotaprofil');
Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('editanggota');
Route::post('/anggota/{id}', [AnggotaController::class, 'update'])->name('updateanggota');

Route::middleware(['auth'])->group(function () {
    Route::get('/profil-saya', function () {
        $anggota = \App\Models\Anggota::findOrFail(auth()->user()->id);
        return view('anggota.profiluser', compact('anggota'));
    })->name('profiluser');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});

Route::prefix('bidangkajian')->group(function () {
    Route::get('/', [BidangKajianController::class, 'index'])->name('bidangkajian.index');
    Route::get('/create', [BidangKajianController::class, 'create'])->name('bidangkajian.create');
    Route::post('/store', [BidangKajianController::class, 'store'])->name('bidangkajian.store');
    Route::get('/{id}/edit', [BidangKajianController::class, 'edit'])->name('bidangkajian.edit');
    Route::put('/{id}', [BidangKajianController::class, 'update'])->name('bidangkajian.update');
    Route::delete('/{id}', [BidangKajianController::class, 'destroy'])->name('bidangkajian.destroy');
});

Route::post('/pinjam', [PeminjamanController::class, 'store'])->name('pinjam.buku');
Route::post('/pengembalian/{id}', [PeminjamanController::class, 'konfirmasiPengembalian'])->name('pengembalian.konfirmasi');
Route::middleware(['auth'])->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::put('/peminjaman/{id}/kembali', [PeminjamanController::class, 'konfirmasiPengembalian'])->name('peminjaman.kembali');
    Route::put('/peminjaman/{id}/rusak', [PeminjamanController::class, 'tandaiRusak'])->name('peminjaman.rusak');
    Route::put('/peminjaman/{id}/hilang', [PeminjamanController::class, 'tandaiHilang'])->name('peminjaman.hilang');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/peminjaman-saya', [\App\Http\Controllers\PeminjamanController::class, 'peminjamanUser'])->name('user.peminjaman');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/download', [App\Http\Controllers\LaporanController::class, 'downloadPdf'])->name('laporan.download');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');