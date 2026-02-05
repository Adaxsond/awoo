<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserRegisController extends Controller
{
    public function registrasi(): View
    {
        return view('registrasi');
    }

    public function store(Request $request): RedirectResponse
    {
        //validasi formnya
        $request->validate([
            'nama' => 'required',
            'nisn' => 'required|min:10|unique:users,nisn',
            'kelas' => 'required',
            'jurusan' => 'required',
            'email' => 'required|email|unique:users,email',
            'nohp' => 'required|min:10',
            'password' => 'required|min:5',
        ], [
            'nisn.unique' => 'NISN sudah terdaftar di sistem.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 5 karakter.',
        ]);
         
        //simpan data ke database melalui model
        $user = User::create([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'email' => $request->email,
            'nohp' => $request->nohp,
            'password' => Hash::make($request->password),
        ]);

        // Login setelah registrasi
        return redirect()->route('loginuser')->with('success', 'Registrasi berhasil, silakan login.');

    }
}
