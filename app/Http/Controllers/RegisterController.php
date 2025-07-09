<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nrp' => 'required|unique:users,id|unique:mahasiswa,nrp',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'nama' => 'required|string|max:40',
            'email' => 'required|email|max:50',
        ]);

        Log::info('Register attempt', $request->only(['nrp', 'username', 'nama', 'email']));

        DB::beginTransaction();
        try {
            User::create([
                'id' => $request->nrp,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'roles_id' => 2,
                'status_active' => 0,
            ]);

            DB::table('mahasiswa')->insert([
                'nrp' => $request->nrp,
                'nama' => $request->nama,
                'alamat' => null,
                'kota' => null,
                'kodepos' => null,
                'sex' => null,
                'email' => $request->email,
                'telepon' => null,
                'hp' => null,
                'tmptlahir' => null,
                'tgllahir' => null,
                'alamatluarkota' => null,
                'kotaluarkota' => null,
                'kodeposluarkota' => null,
                'teleponluarkota' => null,
                'idpropinsi' => 35,
                'iscomplete' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            Log::info('Register success', ['nrp' => $request->nrp]);

            return redirect()->route('home')->with('success', 'Pendaftaran berhasil. Silakan login setelah aktivasi.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Register failed', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Gagal mendaftar: ' . $e->getMessage())->withInput();
        }
    }
}
