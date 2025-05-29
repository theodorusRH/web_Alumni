<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index() {
        // Ambil data kegiatan dari database
        $kegiatan = Kegiatan::all();

        // Tampilkan view kegiatan dengan data tersebut
        return view('kegiatan.index', compact('kegiatan'));
    }

    public function show($id) {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.kegiatan_detail', compact('kegiatan'));
    }

    public function create() {
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tanggal' => 'required|date',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|max:2048', // validasi foto opsional
        ]);

        $data = $request->only('judul', 'tanggal', 'deskripsi');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kegiatan', 'public');
        }

        Kegiatan::create($data);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }


    public function edit($id) {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required',
            'tanggal' => 'required|date',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Cari data kegiatan berdasarkan ID
        $kegiatan = Kegiatan::findOrFail($id);

        // Update field biasa
        $kegiatan->judul = $request->judul;
        $kegiatan->tanggal = $request->tanggal;
        $kegiatan->deskripsi = $request->deskripsi;

        // Jika ada file foto baru di-upload
        if ($request->hasFile('foto')) {
            // Hapus file lama jika ada
            if ($kegiatan->foto && \Storage::disk('public')->exists($kegiatan->foto)) {
                \Storage::disk('public')->delete($kegiatan->foto);
            }

            // Simpan file baru
            $kegiatan->foto = $request->file('foto')->store('kegiatan', 'public');
        }

        // Simpan perubahan ke database
        $kegiatan->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id) {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();
        return redirect('/kegiatan')->with('success', 'Kegiatan berhasil dihapus.');
    }
}

