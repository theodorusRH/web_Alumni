<?php

namespace App\Http\Controllers;

use App\Models\Pendidikan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PendidikanController extends Controller
{
    // Tampilkan daftar pendidikan milik mahasiswa tertentu
    public function index($nrp = null)
    {
        if (!$nrp) {
            $mahasiswas = Mahasiswa::all();
            return view('pendidikan.select_mahasiswa', compact('mahasiswas'));
        }

        $mahasiswa = Mahasiswa::findOrFail($nrp);
        $pendidikans = $mahasiswa->pendidikan()->with('jurusan')->get();

        return view('pendidikan.index', compact('mahasiswa', 'pendidikans'));
    }

    // Tampilkan detail pendidikan
    public function show($id)
    {
        $pendidikan = Pendidikan::with('jurusan', 'mahasiswa')->findOrFail($id);
        return view('pendidikan.index', compact('pendidikan'));
    }
}
