<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Perusahaan;
use App\Models\Propinsi;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $query = Lowongan::with('perusahaan')
            ->where('isactive', 1)
            ->orderBy('tanggal', 'desc');

        // Contoh filter: filter berdasarkan perusahaan (optional)
        if ($request->filled('perusahaan_id')) {
            $query->where('perusahaan_id', $request->perusahaan_id);
        }

        // Contoh pencarian berdasarkan posisi atau judul lowongan (optional)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('posisi', 'like', '%' . $searchTerm . '%')
                ->orWhere('judul', 'like', '%' . $searchTerm . '%');
            });
        }

        $perPage = $request->get('per_page', 15);
        $lowongans = $query->paginate($perPage)->withQueryString();

        $perusahaans = Perusahaan::where('isactive', 1)->get(); // untuk dropdown filter/input

        return view('lowongan.index', compact('lowongans', 'perusahaans'));
    }

    public function publicIndex(Request $request)
    {
        $query = Lowongan::with('perusahaan')
            ->where('isactive', 1)
            ->orderBy('tanggal', 'desc');

        // Contoh pagination di publicIndex juga
        $perPage = $request->get('per_page', 15);
        $lowongans = $query->paginate($perPage)->withQueryString();

        return view('lowongan.publicindex', compact('lowongans'));
    }

    public function create() {
        $propinsis = Propinsi::where('isactive', 1)->get();
        return view('lowongan.create', compact('propinsis'));
    }

    public function storeLowongan(Request $request)
    {
        // Validasi bisa lebih lengkap kalau perlu
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'gajimin' => 'required|numeric',
            'gajimax' => 'required|numeric|gte:gajimin',
            'tanggal' => 'required|date',
            'tanggal_max' => 'required|date|after_or_equal:tanggal',
            'kirim' => 'required|in:email,offline',
            'perusahaan.nama' => 'required|string|max:255',
            'perusahaan.alamat' => 'required|string',
            'perusahaan.kota' => 'required|string|max:255',
            'perusahaan.telepon' => 'required|string|max:50',
            'perusahaan.email' => 'nullable|email',
            'perusahaan.website' => 'nullable|url',
            'perusahaan.idpropinsi' => 'required|exists:propinsi,idpropinsi',
        ]);

        // Simpan perusahaan dulu dengan userid
        $perusahaanData = $request->perusahaan;
        $perusahaanData['userid'] = auth()->id(); // Tambahkan userid dari user yang sedang login
        
        $perusahaan = Perusahaan::create($perusahaanData);

        // Simpan lowongan dengan idperusahaan dari perusahaan yg baru dibuat
        $lowonganData = $request->only([
            'jabatan', 'deskripsi', 'kualifikasi', 'gajimin', 'gajimax', 'tanggal', 'tanggal_max', 'kirim'
        ]);
        $lowonganData['idperusahaan'] = $perusahaan->idperusahaan;
        $lowonganData['userid'] = auth()->id(); // Tambahkan userid untuk lowongan

        Lowongan::create($lowonganData);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan dan perusahaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $lowongan = Lowongan::with('perusahaan')->findOrFail($id);
        $propinsis = Propinsi::where('isactive', 1)->get(); // Tambahkan data propinsi untuk dropdown

        return view('lowongan.edit', compact('lowongan', 'propinsis'));
    }

    public function updateLowongan(Request $request, $id)
    {
        $request->validate([
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'gajimin' => 'required|numeric',
            'gajimax' => 'required|numeric|gte:gajimin',
            'tanggal' => 'required|date',
            'tanggal_max' => 'required|date|after_or_equal:tanggal',
            'kirim' => 'required|in:email,offline',
            'perusahaan.nama' => 'required|string|max:255',
            'perusahaan.alamat' => 'required|string',
            'perusahaan.kota' => 'required|string|max:255',
            'perusahaan.telepon' => 'required|string|max:50',
            'perusahaan.email' => 'nullable|email',  // Ubah menjadi nullable
            'perusahaan.website' => 'nullable|url',
            'perusahaan.idpropinsi' => 'required|exists:propinsi,idpropinsi',
        ]);

        $lowongan = Lowongan::findOrFail($id);

        // Update perusahaan dulu
        $perusahaan = Perusahaan::findOrFail($request->idperusahaan);
        $perusahaanData = $request->input('perusahaan');
        $perusahaanData['userid'] = auth()->id(); // Tambahkan userid
        $perusahaan->update($perusahaanData);

        // Update lowongan
        $lowongan->update([
            'jabatan' => $request->jabatan,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'gajimin' => $request->gajimin,
            'gajimax' => $request->gajimax,
            'tanggal' => $request->tanggal,
            'tanggal_max' => $request->tanggal_max,
            'kirim' => $request->kirim, // Tambahkan field kirim
            'idperusahaan' => $request->idperusahaan,
            'userid' => auth()->id(), // Tambahkan userid untuk lowongan
        ]);

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan dan perusahaan berhasil diperbarui.');
    }

    // Hapus data lowongan
    public function destroyLowongan($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->delete();

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}
