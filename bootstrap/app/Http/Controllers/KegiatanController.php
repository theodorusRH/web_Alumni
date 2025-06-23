<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

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
        foreach ($kegiatan as $k) {
            $directory = public_path('images/kegiatan/' . $k->id);
            if (File::exists($directory)) {
                $files = File::files($directory);
                $filenames = [];
                foreach ($files as $file) {
                    $filenames[] = $file->getFilename();
                }
                $k->filenames = $filenames;
            } else {
                $k->filenames = [];
            }
        }
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

        $kegiatan = Kegiatan::create($data);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $folder = public_path('images/kegiatan/' . $kegiatan->id);

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0777, true);
            }

            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $file->move($folder, $filename);

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
            $folder = public_path('images/kegiatan/' . $kegiatan->id);

            // Hapus gambar lama jika ada
            if ($kegiatan->foto) {
                $oldImagePath = $folder . '/' . $kegiatan->foto;
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0777, true);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $file->move($folder, $filename);

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

