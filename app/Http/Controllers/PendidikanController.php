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


    // Tampilkan form buat tambah pendidikan baru
    public function create($nrp)
    {
        $mahasiswa = Mahasiswa::findOrFail($nrp);
        // Kalau ada data jurusan, ambil juga untuk dropdown
        $jurusans = \App\Models\Jurusan::all();

        return view('pendidikan.create', compact('mahasiswa', 'jurusans'));
    }

    // Simpan data pendidikan baru
    public function store(Request $request, $nrp)
    {
        $request->validate([
            'idjurusan' => 'required|exists:jurusan,idjurusan',
            'angkatan' => 'required|integer',
            'tanggallulus' => 'nullable|date',
            'jmlsemester' => 'nullable|integer',
            'ipk' => 'nullable|numeric',
        ]);

        $data = $request->all();
        $data['nrp'] = $nrp;

        Pendidikan::create($data);

        return redirect()->route('pendidikan.index', $nrp)
            ->with('success', 'Data pendidikan berhasil ditambahkan');
    }

    // Tampilkan detail pendidikan
    public function show($id)
    {
        $pendidikan = Pendidikan::with('jurusan', 'mahasiswa')->findOrFail($id);
        return view('pendidikan.show', compact('pendidikan'));
    }

    // Form edit pendidikan
    public function edit($id)
    {
        $pendidikan = Pendidikan::findOrFail($id);
        $jurusans = \App\Models\Jurusan::all();

        return view('pendidikan.edit', compact('pendidikan', 'jurusans'));
    }

    // Update pendidikan
    public function update(Request $request, $id)
    {
        $pendidikan = Pendidikan::findOrFail($id);

        $request->validate([
            'idjurusan' => 'required|exists:jurusan,idjurusan',
            'angkatan' => 'required|integer',
            'tanggallulus' => 'nullable|date',
            'jmlsemester' => 'nullable|integer',
            'ipk' => 'nullable|numeric',
        ]);

        $pendidikan->update($request->all());

        return redirect()->route('pendidikan.show', $id)
            ->with('success', 'Data pendidikan berhasil diupdate');
    }

    // Hapus pendidikan
    public function destroy($id)
    {
        $pendidikan = Pendidikan::findOrFail($id);
        $pendidikan->delete();

        return redirect()->back()->with('success', 'Data pendidikan berhasil dihapus');
    }
}
