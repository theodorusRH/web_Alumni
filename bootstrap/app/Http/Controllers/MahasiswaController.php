<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Propinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with(['propinsi', 'pendidikan']);

        // Filter status kelulusan (iscomplete)
        if ($request->filled('iscomplete')) {
            $query->where('iscomplete', $request->iscomplete);
        }

        // Filter berdasarkan provinsi
        if ($request->filled('idpropinsi')) {
            $query->where('idpropinsi', $request->idpropinsi);
        }

        // Filter berdasarkan kota
        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }

        // Pencarian berdasarkan nama atau nrp
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nrp', 'like', '%' . $searchTerm . '%')
                ->orWhere('nama', 'like', '%' . $searchTerm . '%');
            });
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $mahasiswa = $query->paginate($perPage)->withQueryString();

        // Data untuk filter dropdown
        $propinsi = Propinsi::orderBy('nama')->get();
        $cities = Mahasiswa::select('kota')
            ->whereNotNull('kota')
            ->where('kota', '!=', '')
            ->groupBy('kota')
            ->orderBy('kota')
            ->pluck('kota');

        return view('mahasiswa.index', compact('mahasiswa', 'propinsi', 'cities'));
    }


    public function show($nrp)
    {
        $mahasiswa = Mahasiswa::with(['propinsi', 'pendidikan', 'pekerjaan'])
            ->findOrFail($nrp);
        
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function export(Request $request)
    {
        // Logic untuk export data (CSV, Excel, PDF)
        // Menggunakan query yang sama dengan index tapi tanpa pagination
        
        $query = Mahasiswa::with(['propinsi', 'pendidikan']);
        
        // Apply same filters as index method
        // ... (copy filter logic from index method)
        
        $mahasiswa = $query->get();
        
        // Return export file (implementation depends on chosen export library)
        return response()->json(['message' => 'Export functionality to be implemented']);
    }
}