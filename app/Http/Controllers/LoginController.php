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
    // public function login(Request $request)
    // {
    //     // Validasi inputan
    //     $request->validate([
    //         'id' => 'required',
    //         'password' => 'required',
    //     ]);

    //     // Mencari user berdasarkan id
    //     $user = User::where('id', $request->id)->first();

    //     // Cek apakah id ditemukan
    //     if (!$user) {
    //         return back()->withErrors(['id' => 'id tidak ditemukan']);
    //     }

    //     // Cek apakah akun aktif
    //     if ($user->status_active != 1) {
    //         return back()->withErrors(['id' => 'Akun Anda tidak aktif']);
    //     }

    //     // Cek password
    //     if (!Hash::check($request->password, $user->password)) {
    //         return back()->withErrors(['password' => 'Password salah']);
    //     }

    //     // Login berhasil
    //     Auth::login($user);

    //     // Log data user untuk debugging
    //     \Log::info('Login berhasil', ['user' => $user]);

    //     // Redirect berdasarkan role
    //     if ($user->roles->name == 'admin') {
    //         return redirect()->route('dashboard.index'); // Admin
    //     } else {
    //         return redirect()->route('dashboard.user'); // User
    //     }
    // }

    public function login(Request $request)
    {
        $request->validate([
            'id' => 'required', // ini tetap id/email (input sama)
            'password' => 'required',
        ]);

        $loginInput = $request->id;

        // Cari user berdasarkan ID (NRP)
        $user = User::where('id', $loginInput)->first();

        // Jika tidak ketemu berdasarkan ID, coba cari berdasarkan email mahasiswa
        if (!$user) {
            $mahasiswa = \App\Models\Mahasiswa::where('email', $loginInput)->first();
            if ($mahasiswa) {
                $user = User::where('id', $mahasiswa->nrp)->first(); // user.id = mahasiswa.nrp
            }
        }

        // Jika tetap tidak ditemukan
        if (!$user) {
            return back()->withErrors(['id' => 'ID atau Email tidak ditemukan']);
        }

        // Cek status aktif
        if ($user->status_active != 1) {
            return back()->withErrors(['id' => 'Akun Anda tidak aktif']);
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        // Login sukses
        Auth::login($user);
        \Log::info('Login berhasil', ['user' => $user]);

        // Redirect sesuai role
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
