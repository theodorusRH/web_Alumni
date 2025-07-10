<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\Mahasiswa;
use App\Models\JenisPekerjaan;
use App\Models\Propinsi;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    // Menampilkan daftar pekerjaan berdasarkan NRP mahasiswa
    public function index($nrp = null)
    {
        if (!$nrp) {
            $mahasiswas = Mahasiswa::all();
            return view('pekerjaan.select_mahasiswa', compact('mahasiswas'));
        }

        $mahasiswa = Mahasiswa::findOrFail($nrp);
        $pekerjaans = $mahasiswa->pekerjaan()->with('jenisPekerjaan')->get();

        return view('pekerjaan.index', compact('mahasiswa', 'pekerjaans'));
    }
}
