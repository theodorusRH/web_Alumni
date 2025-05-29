<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Menampilkan dashboard untuk user setelah login
    public function index()
    {
        // Ambil data user yang sedang login
        $user = auth()->user();

        // Kirim ke view dashboard.user
        return view('dashboard.user', ['user' => auth()->user()]);
    }
}

