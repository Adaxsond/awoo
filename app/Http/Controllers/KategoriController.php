<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('nama')->get();
        return view('kategori.kategoriindex', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.kategoritambah');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:100']);
        Kategori::create(['nama' => $request->nama]);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.kategoriedit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|max:100']);
        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kategori::destroy($id);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
