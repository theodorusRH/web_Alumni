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
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('judul', 'tanggal', 'deskripsi');

        // Buat data kegiatan dulu tanpa foto
        $kegiatan = Kegiatan::create($data);

        if ($request->hasFile('foto')) {
            // Buat folder berdasarkan ID kegiatan
            $path = public_path('images/kegiatan/' . $kegiatan->id);

            if (!file_exists($path)) {
                mkdir($path, 0755, true); // buat folder jika belum ada
            }

            // Simpan file ke folder tersebut
            $file = $request->file('foto');
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);

            // Simpan nama file ke kolom `foto` di database (jika ada)
            $kegiatan->foto = $filename;
            $kegiatan->save();
        }

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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cari data kegiatan berdasarkan ID
        $kegiatan = Kegiatan::findOrFail($id);

        // Update field biasa
        $kegiatan->judul = $request->judul;
        $kegiatan->tanggal = $request->tanggal;
        $kegiatan->deskripsi = $request->deskripsi;

        // Jika ada file foto baru di-upload
        if ($request->hasFile('foto')) {
            $path = public_path('images/kegiatan/' . $kegiatan->id);

            // Buat folder jika belum ada
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            // Hapus file lama jika ada
            if ($kegiatan->foto && file_exists($path . '/' . $kegiatan->foto)) {
                unlink($path . '/' . $kegiatan->foto);
            }

            // Simpan file baru
            $file = $request->file('foto');
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);

            // Simpan nama file ke kolom
            $kegiatan->foto = $filename;
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

