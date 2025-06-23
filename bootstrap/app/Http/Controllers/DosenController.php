<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TugasAkhir;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = auth()->user();
        $kode = $dosen->id; // asumsi user.id = dosen.kode

        $daftarTA = TugasAkhir::with('mahasiswa')
            ->where('kode_dosen1', $kode)
            ->orWhere('kode_dosen2', $kode)
            ->get();

        return view('dosen.tugasakhir', compact('daftarTA'));
    }

}
