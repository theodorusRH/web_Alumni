<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);

        // Mencari user berdasarkan id
        $user = User::where('id', $request->id)->first();

        // Cek apakah id ditemukan
        if (!$user) {
            return back()->withErrors(['id' => 'id tidak ditemukan']);
        }

        // Cek apakah akun aktif
        if ($user->status_active != 1) {
            return back()->withErrors(['id' => 'Akun Anda tidak aktif']);
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        // Login berhasil
        Auth::login($user);

        // Log data user untuk debugging
        \Log::info('Login berhasil', ['user' => $user]);

        // Redirect berdasarkan role
        if ($user->roles->name == 'admin') {
            return redirect()->route('dashboard.index'); // Admin
        } else {
            return redirect()->route('dashboard.user'); // User
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Hapus session
        $request->session()->invalidate();

        // Regenerasi token CSRF untuk keamanan
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect('/');
    }
}
