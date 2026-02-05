<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
    $status = $request->query('status');
    $keyword = $request->query('keyword');

    $query = Peminjaman::with(['user', 'buku']);

    if ($status == 'telat') {
        $query->where('status', 'dipinjam')
              ->whereDate('tanggal_jatuh_tempo', '<', now());
    } elseif ($status) {
        $query->where('status', $status);
    }

    if ($keyword) {
        $query->whereHas('buku', function($q) use ($keyword) {
            $q->where('judul', 'like', '%' . $keyword . '%');
        });
    }

    $peminjaman = $query->orderBy('created_at', 'desc')->paginate(12);

    $users = \App\Models\User::all();
    $buku = \App\Models\Buku::all();

    return view('peminjaman.peminjamanindex', compact('peminjaman', 'users', 'buku'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1|max:3',
        ]);

        $user = Auth::user();

        // Cek batas pinjam 3 buku
        $jumlahPinjaman = Peminjaman::where('user_id', $user->id)
                                    ->where('status', 'dipinjam')
                                    ->sum('jumlah');

        if ($jumlahPinjaman + $request->jumlah > 3) {
            return redirect()->back()->with('error', 'Melebihi batas maksimal 3 pinjaman! Kembalikan beberapa buku terlebih dahulu.');
        }

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok buku tidak mencukupi.');
        }

        // Gunakan transaksi database untuk memastikan konsistensi data
        DB::beginTransaction();

        try {
            // Simpan peminjaman
            Peminjaman::create([
                'user_id' => $user->id,
                'buku_id' => $buku->id,
                'jumlah' => $request->jumlah,
                'tanggal_pinjam' => now(),
                'tanggal_jatuh_tempo' => now()->addDays(3),
                'status' => 'dipinjam',
            ]);

            // Kurangi stok
            $buku->stok -= $request->jumlah;
            $buku->save();

            DB::commit();

            return redirect()->route('indexbuku')->with('success', 'Buku berhasil dipinjam.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses peminjaman. Silakan coba lagi.');
        }
    }


    public function konfirmasiPengembalian($id, Request $request)
    {
    $pinjam = Peminjaman::findOrFail($id);

    if ($pinjam->status == 'dikembalikan') {
        return back()->with('error', 'Buku sudah dikembalikan.');
    }

    $tanggalPinjam = Carbon::parse($pinjam->tanggal_pinjam);
    $tanggalKembali = Carbon::now();
    $selisihHari = $tanggalKembali->diffInDays($tanggalPinjam);

    $dendaTerlambat = max(0, ($selisihHari - 3)) * 5000;
    $dendaKondisi = 0;

    // Ambil jumlah yang dikembalikan, jika tidak ada maka gunakan jumlah semula
    $jumlahDikembalikan = $request->jumlah ?? $pinjam->jumlah;

    // Validasi jumlah pengembalian tidak melebihi jumlah dipinjam
    if ($jumlahDikembalikan > $pinjam->jumlah) {
        return back()->with('error', 'Jumlah pengembalian tidak boleh melebihi jumlah yang dipinjam.');
    }

    if ($request->kondisi == 'rusak') {
        $dendaKondisi = 50000;
    } elseif ($request->kondisi == 'hilang') {
        $dendaKondisi = $request->input('harga_buku');
    }

    $pinjam->update([
        'tanggal_kembali' => $tanggalKembali,
        'status' => 'dikembalikan',
        'denda' => $dendaTerlambat,
        'kondisi' => $request->kondisi,
        'jumlah' => $jumlahDikembalikan, // Update jumlah jika hanya sebagian yang dikembalikan
        'denda_kondisi' => $dendaKondisi
    ]);

    // Restore stock accordingly - only for books returned in good condition
    $buku = $pinjam->buku;
    if (!$request->kondisi || $request->kondisi == 'baik') {
        $buku->stok += $jumlahDikembalikan;
        $buku->save();
    }

    return back()->with('success', 'Pengembalian dikonfirmasi sebanyak ' . $jumlahDikembalikan . ' buku.');
    }

    public function peminjamanUser(Request $request)
    {
    $user = Auth::user();
    $status = $request->query('status');

    $query = Peminjaman::with('buku')
        ->where('user_id', $user->id);

    if ($status) {
        $query->where('status', $status);
    }

    $peminjaman = $query->latest()->get();

    return view('peminjaman.userpeminjaman', compact('peminjaman', 'status'));
    }

    public function tandaiRusak($id, Request $request)
    {
    $peminjaman = Peminjaman::findOrFail($id);

    if ($peminjaman->status === 'dikembalikan') {
        return back()->with('error', 'Buku sudah dikembalikan.');
    }

    // Ambil jumlah yang rusak, jika tidak ada maka gunakan jumlah semula
    $jumlahRusak = $request->jumlah ?? $peminjaman->jumlah;

    // Validasi jumlah buku rusak tidak melebihi jumlah dipinjam
    if ($jumlahRusak > $peminjaman->jumlah) {
        return back()->with('error', 'Jumlah buku rusak tidak boleh melebihi jumlah yang dipinjam.');
    }

    $tanggalPinjam = Carbon::parse($peminjaman->tanggal_pinjam);
    $tanggalKembali = Carbon::now();
    $selisihHari = $tanggalKembali->diffInDays($tanggalPinjam);

    $dendaTerlambat = max(0, ($selisihHari - 3)) * 5000;
    $dendaKondisi = 50000 * $jumlahRusak; // Denda berdasarkan jumlah buku rusak

    $peminjaman->update([
        'tanggal_kembali' => $tanggalKembali,
        'status' => 'dikembalikan',
        'kondisi' => 'rusak',
        'jumlah' => $jumlahRusak, // Update jumlah buku yang rusak
        'denda' => $dendaTerlambat,
        'denda_kondisi' => $dendaKondisi,
    ]);

    // Note: For damaged books, stock is not restored since they are no longer usable
    // The stock was already reduced during borrowing and remains reduced

    return back()->with('success', 'Status peminjaman ditandai sebagai rusak untuk ' . $jumlahRusak . ' buku dan denda diterapkan.');
   }

    public function tandaiHilang($id, Request $request)
    {
    $peminjaman = Peminjaman::findOrFail($id);

    if ($peminjaman->status === 'dikembalikan') {
        return back()->with('error', 'Buku sudah dikembalikan.');
    }

    $request->validate([
        'harga_buku' => 'required|numeric|min:0',
    ]);

    // Ambil jumlah yang hilang, jika tidak ada maka gunakan jumlah semula
    $jumlahHilang = $request->jumlah ?? $peminjaman->jumlah;

    // Validasi jumlah buku hilang tidak melebihi jumlah dipinjam
    if ($jumlahHilang > $peminjaman->jumlah) {
        return back()->with('error', 'Jumlah buku hilang tidak boleh melebihi jumlah yang dipinjam.');
    }

    $tanggalPinjam = Carbon::parse($peminjaman->tanggal_pinjam);
    $tanggalKembali = Carbon::now();
    $selisihHari = $tanggalKembali->diffInDays($tanggalPinjam);

    $dendaTerlambat = max(0, ($selisihHari - 3)) * 5000;
    $dendaKondisi = $request->input('harga_buku') * $jumlahHilang; // Denda berdasarkan harga buku dan jumlah yang hilang

    $peminjaman->update([
        'tanggal_kembali' => $tanggalKembali,
        'status' => 'dikembalikan',
        'kondisi' => 'hilang',
        'jumlah' => $jumlahHilang, // Update jumlah buku yang hilang
        'denda' => $dendaTerlambat,
        'denda_kondisi' => $dendaKondisi,
    ]);

    // Note: For lost books, stock is not restored since they are no longer available
    // The stock was already reduced during borrowing and remains reduced

    return back()->with('success', 'Status peminjaman ditandai sebagai hilang untuk ' . $jumlahHilang . ' buku dan denda diterapkan.');
    }


}
