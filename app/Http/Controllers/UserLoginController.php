<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserLoginController extends Controller
{
    public function loginuser()
    {
        return view('loginuser'); 
    }

    // Memproses login user
    public function proseslogin(Request $request)
    {
        $credentials = $request->only('nisn', 'password');

        $user = User::where('nisn', $credentials['nisn'])->where('role', '1')->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {Auth::login($user);
            return redirect()->route('beranda');;
        }

        return back()->withErrors([
            'nisn' => 'NISN atau password salah!',
        ]);
        
    }
    
    public function beranda()
    {
    $users = User::orderBy('created_at', 'desc')->paginate(10); // urutkan dari terbaru
    return view('beranda', compact('users'));
    }
}
