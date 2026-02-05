<?php

namespace App\Http\Controllers;

use App\Models\BidangKajian;
use Illuminate\Http\Request;

class BidangKajianController extends Controller
{
    public function index()
    {
        $bidangkajian = BidangKajian::orderBy('nama')->get();
        return view('bidangkajian.bidangkajianindex', compact('bidangkajian'));
    }

    public function create()
    {
        return view('bidangkajian.bidangkajiantambah');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:100']);
        BidangKajian::create(['nama' => $request->nama]);
        return redirect()->route('bidangkajian.index')->with('success', 'Bidang Kajian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bidangkajian = BidangKajian::findOrFail($id);
        return view('bidangkajian.bidangkajianedit', compact('bidangkajian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|max:100']);
        $bidangkajian = BidangKajian::findOrFail($id);
        $bidangkajian->update(['nama' => $request->nama]);
        return redirect()->route('bidangkajian.index')->with('success', 'Bidang Kajian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        BidangKajian::destroy($id);
        return redirect()->route('bidangkajian.index')->with('success', 'Bidang Kajian berhasil dihapus.');
    }
}
