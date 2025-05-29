<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniNews;
use App\Models\Kegiatan;
use App\Models\Lowongan;
use App\Models\Mahasiswa;

class PublicController extends Controller
{
    public function index()
    {
        $news = AlumniNews::where('isactive', 1)
                          ->orderBy('tanggalbuat', 'desc')
                          ->take(3)
                          ->get();
        
        $lowongan = Lowongan::with('perusahaan')
                           ->where('isactive', 1)
                           ->where('tanggal_max', '>=', now())
                           ->orderBy('tanggal', 'desc')
                           ->take(5)
                           ->get();
        
        $stats = [
            'totalAlumni' => Mahasiswa::whereHas('pendidikan', function($query) {
                $query->whereNotNull('tanggallulus');
            })->count(),
            'totalLowongan' => Lowongan::where('isactive', 1)
                                     ->where('tanggal_max', '>=', now())
                                     ->count()
        ];
        
        return view('welcome', compact('news', 'lowongan', 'stats'));
    }

    public function berita()
    {
        $news = AlumniNews::where('isactive', 1)
                          ->orderBy('tanggalbuat', 'desc')
                          ->paginate(10);
        
        return view('berita', compact('news'));
    }

    public function kegiatan()
    {
        $kegiatan = Kegiatan::orderBy('tanggal', 'desc')->paginate(10);
        return view('kegiatan.index', compact('kegiatan'));
    }

    public function kegiatanDetail($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.show', compact('kegiatan'));
    }

    public function kontak()
    {
        return view('kontak');
    }
}
