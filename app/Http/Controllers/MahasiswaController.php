<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Propinsi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with(['propinsi', 'pendidikan', 'pekerjaan'])
                            ->orderBy('created_at', 'asc');

        // Filter status kelulusan (iscomplete)
        // Pastikan hanya filter jika ada nilai yang dikirim dan bukan string kosong
        if ($request->has('iscomplete') && $request->iscomplete !== '' && $request->iscomplete !== null) {
            $query->where('iscomplete', $request->iscomplete);
        }

        // Filter berdasarkan provinsi
        if ($request->filled('idpropinsi')) {
            $query->where('idpropinsi', $request->idpropinsi);
        }

        // Filter berdasarkan kota
        if ($request->filled('kota')) {
            $query->where('kota', 'like', '%' . $request->kota . '%');
        }

        // Pencarian berdasarkan nama atau nrp
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nrp', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nama', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter berdasarkan angkatan
        if ($request->filled('angkatan')) {
            $query->where('angkatan', 'like', '%' . $request->angkatan . '%');
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

    public function pendingAlumni(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $mahasiswa = Mahasiswa::where('iscomplete', '0')
                        ->orderBy('created_at', 'asc')
                        ->paginate($perPage)
                        ->withQueryString();

        // Data filter tambahan jika view-nya butuh (optional)
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

    public function showDetail($nrp)
    {
        $mahasiswa = Mahasiswa::with('propinsi')->findOrFail($nrp);
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function export(Request $request)
    {
        // Logic untuk export data (CSV, Excel, PDF)
        // Menggunakan query yang sama dengan index tapi tanpa pagination
        
        $query = Mahasiswa::with(['propinsi', 'pendidikan']);
        
        // Apply same filters as index method
        if ($request->has('iscomplete') && $request->iscomplete !== '' && $request->iscomplete !== null) {
            $query->where('iscomplete', $request->iscomplete);
        }

        if ($request->filled('idpropinsi')) {
            $query->where('idpropinsi', $request->idpropinsi);
        }

        if ($request->filled('kota')) {
            $query->where('kota', 'like', '%' . $request->kota . '%');
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nrp', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nama', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', 'like', '%' . $request->angkatan . '%');
        }
        
        $mahasiswa = $query->get();
        
        // Return export file (implementation depends on chosen export library)
        return response()->json(['message' => 'Export functionality to be implemented']);
    }

    public function toggleStatus($nrp)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($nrp);
        
        // Toggle status kelulusan mahasiswa
        $mahasiswa->iscomplete = !$mahasiswa->iscomplete;
        $mahasiswa->save();

        // Toggle juga status user yang terkait
        if ($mahasiswa->user) {
            $mahasiswa->user->status_active = $mahasiswa->iscomplete ? 1 : 0;
            $mahasiswa->user->save();
        }

        return redirect()->back()->with('success', 'Status Mahasiswa dan User berhasil diperbarui.');
    }
}