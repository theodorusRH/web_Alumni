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
        $query = Lowongan::with('perusahaan')->orderBy('tanggal', 'desc');

        if ($request->filled('perusahaan_id')) {
            $query->where('idperusahaan', $request->perusahaan_id);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('jabatan', 'like', "%$searchTerm%")
                  ->orWhere('deskripsi', 'like', "%$searchTerm%");
            });
        }

        $perPage = $request->get('per_page', 15);
        $lowongans = $query->paginate($perPage)->withQueryString();
        $perusahaans = Perusahaan::where('isactive', 1)->get();

        return view('lowongan.index', compact('lowongans', 'perusahaans'));
    }

    public function publicIndex(Request $request)
    {
        $lowongans = Lowongan::with('perusahaan')
            ->where('isactive', 1)
            ->where('isapproved', 1)
            ->latest()
            ->get();

        return view('lowongan.publicindex', compact('lowongans'));
    }

    public function create()
    {
        $propinsis = Propinsi::where('isactive', 1)->get();
        return view('lowongan.create', compact('propinsis'));
    }

    public function storeLowongan(Request $request)
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
            'perusahaan.email' => 'nullable|email',
            'perusahaan.website' => 'nullable|url',
            'perusahaan.idpropinsi' => 'required|exists:propinsi,idpropinsi',
        ]);

        $perusahaanData = $request->perusahaan;
        $perusahaanData['userid'] = auth()->id();
        $perusahaan = Perusahaan::create($perusahaanData);

        $lowonganData = $request->only([
            'jabatan', 'deskripsi', 'kualifikasi', 'gajimin', 'gajimax', 'tanggal', 'tanggal_max', 'kirim'
        ]);
        $lowonganData['idperusahaan'] = $perusahaan->idperusahaan;
        $lowonganData['userid'] = auth()->id();
        $lowonganData['isapproved'] = false;
        $lowonganData['isactive'] = true;

        Lowongan::create($lowonganData);

        return redirect()->route('lowongan.mine')->with('success', 'Lowongan berhasil ditambahkan dan menunggu persetujuan.');
    }

    public function edit($id)
    {
        $lowongan = Lowongan::with('perusahaan')->findOrFail($id);
        $propinsis = Propinsi::where('isactive', 1)->get();

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
            'perusahaan.email' => 'nullable|email',
            'perusahaan.website' => 'nullable|url',
            'perusahaan.idpropinsi' => 'required|exists:propinsi,idpropinsi',
        ]);

        $lowongan = Lowongan::findOrFail($id);
        $perusahaan = Perusahaan::findOrFail($request->idperusahaan);

        $perusahaanData = $request->input('perusahaan');
        $perusahaanData['userid'] = auth()->id();
        $perusahaan->update($perusahaanData);

        $lowongan->update([
            'jabatan' => $request->jabatan,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'gajimin' => $request->gajimin,
            'gajimax' => $request->gajimax,
            'tanggal' => $request->tanggal,
            'tanggal_max' => $request->tanggal_max,
            'kirim' => $request->kirim,
            'idperusahaan' => $request->idperusahaan,
            'userid' => auth()->id(),
        ]);

        return redirect()->route('lowongan.mine')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroyLowongan($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->delete();

        return redirect()->route('lowongan.mine')->with('success', 'Lowongan berhasil dihapus.');
    }

    public function approve($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->isapproved = true;
        $lowongan->save();

        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil disetujui.');
    }

    public function mine()
    {
        $user = auth()->user();

        $lowongans = Lowongan::with('perusahaan')
            ->where('userid', $user->username)
            ->orderByDesc('created_at')
            ->get();

        return view('lowongan.mine', compact('lowongans'));
    }
}
