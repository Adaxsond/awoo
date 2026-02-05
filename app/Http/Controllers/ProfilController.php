<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profil.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_induk' => 'nullable|string|max:20',
            'kelas' => 'nullable|string|max:10',
            'jurusan' => 'nullable|string|max:50',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_induk' => $request->no_induk,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui!');
    }
}