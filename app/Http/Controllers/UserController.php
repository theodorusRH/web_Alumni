<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Propinsi;
use App\Models\TugasAkhir;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function profile()
    {
        $user = auth()->user();

        $mahasiswa = $user->mahasiswa;
        $tugasAkhir = $mahasiswa?->tugasAkhir()?->with(['dosen1', 'dosen2'])->first();

        $propinsiList = DB::table('propinsi')->get();
        $dosenList = Dosen::all();

        return view('profile.index', compact('user', 'mahasiswa', 'tugasAkhir', 'propinsiList', 'dosenList'));
    }


    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'username' => 'required|string',
            'password' => 'nullable|string|min:5',
        ];

        // Hanya non-mahasiswa bisa update id
        if ($user->roles->name !== 'mahasiswa') {
            $rules['id'] = 'required|string';
        }

        $request->validate($rules);

        if ($user->roles->name !== 'mahasiswa') {
            $user->id = $request->id;
        }

        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/foto_user'), $filename); // simpan di public/images/foto_user
            $user->foto = $filename;
        }

        $user->save();

        // Update data mahasiswa jika mahasiswa
        if ($user->roles->name === 'mahasiswa' && $user->mahasiswa) {
            $user->mahasiswa->update($request->only([
                'nama', 'alamat', 'kota', 'kodepos', 'sex', 'email', 'telepon',
                'hp', 'tmptlahir', 'tgllahir', 'alamatluarkota', 'kotaluarkota',
                'kodeposluarkota', 'teleponluarkota', 'idpropinsi'
            ]));
        }

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}

