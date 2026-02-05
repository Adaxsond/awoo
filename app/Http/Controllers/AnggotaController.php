<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = ['10', '11', '12'];
        $jurusanList = ['AK', 'MK', 'TKJ', 'TM', 'TO', 'TKG'];

        $query = Anggota::query();

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%$search%")
              ->orWhere('nisn', 'like', "%$search%");
        });
        }

        $users = $query->paginate(12);

        return view('anggota.anggotaindex', [
            'anggota' => $users,
            'daftarKelas' => $kelasList,
            'daftarJurusan' => $jurusanList
        ]);
    }

    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.anggotaprofil', compact('anggota'));
    }

    public function edit($id)
    {
    $anggota = Anggota::findOrFail($id);
    return view('anggota.anggotaedit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
    $anggota = Anggota::findOrFail($id);

    $request->validate([
        'nama' => 'required',
        'nisn' => 'required|unique:users,nisn,' . $anggota->id,
        'kelas' => 'required',
        'jurusan' => 'required',
        'email' => 'required|email|unique:users,email,' . $anggota->id,
        'nohp' => 'required',
    ]);

    $anggota->update($request->all());

    return redirect()->route('profiluser')->with('success', 'Profil anggota berhasil diperbarui.');
    }

}
