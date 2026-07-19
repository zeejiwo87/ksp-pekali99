<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // FORM LOGIN
    public function login()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function loginProses(Request $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'status' => 'aktif'
        ];

        if (Auth::attempt($credentials)) {

            auth()->user()->update([
                'last_login_at' => now()
            ]);

            return redirect()->route('dashboard.index');
        }

        return back()->with('error', 'Username atau Password salah');
    }

    // LOGOUT
    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}
}