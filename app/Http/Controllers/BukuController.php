<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\BidangKajian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function create()
    {
        $kategori = Kategori::all();
        $bidangkajian = BidangKajian::all();
        return view('buku.bukutambah', compact('kategori', 'bidangkajian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'stok' => 'required|integer',
            'penerbit' => 'required',
            'tanggal_terbit' => 'required|digits:4|integer|max:' . date('Y') ,
            'kode_rak' => 'required',
            'kategori_id' => 'required|exists:kategori,id',
            'bidang_kajian_id' => 'required|exists:bidang_kajian,id',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->storeAs('public/buku', $nama_gambar);
            $data['gambar'] = 'buku/' . $nama_gambar;
        }

        Buku::create($data);

        return redirect()->route('indexbuku')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function index(Request $request)
    {
    $query = Buku::query();

    // Pencarian berdasarkan keyword
    if ($request->filled('keyword')) {
        $query->where(function ($q) use ($request) {
            $q->where('judul', 'like', '%' . $request->keyword . '%')
              ->orWhere('penerbit', 'like', '%' . $request->keyword . '%');
        });
    }

    // Filter kategori
    if ($request->filled('kategori_id')) {
        $query->where('kategori_id', $request->kategori_id);
    }

    // Filter bidang kajian
    if ($request->filled('bidang_kajian_id')) {
        $query->where('bidang_kajian_id', $request->bidang_kajian_id);
    }

    $buku = $query->with('kategori', 'bidangkajian')->paginate(10);
    $kategori = Kategori::all();
    $bidangkajian = BidangKajian::all();

    // Get books by category for display (5 from each category)
    $bukuPerKategori = collect();
    foreach ($kategori as $kat) {
        $bukuInCategory = Buku::where('kategori_id', $kat->id)
                              ->with('kategori', 'bidangkajian')
                              ->limit(5)
                              ->get();
        if ($bukuInCategory->count() > 0) {
            $bukuPerKategori->put($kat->id, [
                'kategori' => $kat,
                'buku' => $bukuInCategory
            ]);
        }
    }

    return view('buku.bukuindex', compact('buku', 'kategori', 'bidangkajian', 'bukuPerKategori'));
    }


    public function edit($id)
    {
    $buku = Buku::findOrFail($id);
    $kategori = Kategori::all();
    $bidangkajian = BidangKajian::all();
    return view('buku.bukuedit', compact('buku', 'kategori', 'bidangkajian'));
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'judul' => 'required',
        'stok' => 'required|integer',
        'penerbit' => 'required',
        'tanggal_terbit' => 'required|digits:4|integer|max:' . date('Y'),
        'kode_rak' => 'required',
        'kategori_id' => 'required|exists:kategori,id',
        'bidang_kajian_id' => 'required|exists:bidang_kajian,id',
        'deskripsi' => 'required',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $buku = Buku::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($buku->gambar) {
            $gambarPath = storage_path('app/public/' . $buku->gambar);
            if (file_exists($gambarPath)) {
                unlink($gambarPath);
            }
        }

        $gambar = $request->file('gambar');
        $nama_gambar = time() . '_' . $gambar->getClientOriginalName();
        $gambar->storeAs('public/buku', $nama_gambar);
        $data['gambar'] = 'buku/' . $nama_gambar;
    }

    $buku->update($data);

    return redirect()->route('indexbuku')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
    $buku = Buku::findOrFail($id);
    $buku->delete();
    return redirect()->route('indexbuku')->with('success', 'Buku berhasil dihapus.');
    }

    public function byBidang($bidangId, Request $request)
    {
        $bidangKajian = BidangKajian::findOrFail($bidangId);
        $query = Buku::query();

        // Pencarian berdasarkan keyword
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->keyword . '%')
                  ->orWhere('penerbit', 'like', '%' . $request->keyword . '%');
            });
        }

        // Filter tetap berdasarkan bidang kajian yang dipilih
        $query->where('bidang_kajian_id', $bidangId);

        // Filter tambahan untuk kategori jika ada
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $buku = $query->with('kategori', 'bidangkajian')->paginate(10);
        $kategori = Kategori::all();
        $bidangkajian = BidangKajian::all();

        return view('buku.bukuindex', compact('buku', 'kategori', 'bidangkajian', 'bidangKajian'));
    }
}
