<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->where('role', '0')->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {Auth::login($user);
            return redirect('/beranda');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau Anda bukan admin.',
        ]);
    }

    public function beranda()
    {
    $users = User::orderBy('created_at', 'desc')->paginate(10); // urutkan dari terbaru
    return view('beranda', compact('users'));
    }
}
