<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniNews;
use Illuminate\Support\Facades\Auth;

class AlumniNewsController extends Controller
{
    public function index()
    {
        $alumninews = AlumniNews::orderBy('tanggalbuat', 'desc')->paginate(10);
        return view('alumninews.index', compact('alumninews'));
    }

    public function home()
    {
        $alumninews = AlumniNews::orderBy('tanggalbuat', 'desc')->get(); // atau paginate

        return view('home', compact('alumninews'));
    }

    public function show($id) {
        $alumninews = AlumniNews::findOrFail($id);
        return view('alumninews.alumninews_detail', compact('alumninews'));
    }

    public function showhome($id) {
        $alumninews = AlumniNews::findOrFail($id);
        return view('home_detail', compact('alumninews'));
    }

    public function create()
    {
        return view('alumninews.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Ambil data utama
        $data = $request->only('judul', 'isi');
        $data['userid'] = Auth::user()->username ?? 'admin';
        $data['tanggalbuat'] = now();
        $data['isactive'] = 1;

        // Buat record terlebih dahulu tanpa foto
        $berita = AlumniNews::create($data);

        if ($request->hasFile('foto')) {
            // Buat folder berdasarkan ID berita
            $path = public_path('images/alumninews/' . $berita->idalumninews);

            if (!file_exists($path)) {
                mkdir($path, 0755, true); // buat folder jika belum ada
            }

            // Simpan file ke folder tersebut
            $file = $request->file('foto');
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);

            // Update kolom foto di database
            $berita->foto = $filename;
            $berita->save();
        }

        return redirect()->route('admin.alumninews.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit($id)
    {
        $alumninews = AlumniNews::findOrFail($id);
        return view('alumninews.edit', compact('alumninews'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $alumninews = AlumniNews::findOrFail($id);

        // Update field biasa
        $alumninews->judul = $request->judul;
        $alumninews->isi = $request->isi;

        // Jika ada file foto baru di-upload
        if ($request->hasFile('foto')) {
            $path = public_path('images/alumninews/' . $alumninews->idalumninews);

            // Buat folder jika belum ada
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            // Hapus file lama jika ada
            if ($alumninews->foto && file_exists($path . '/' . $alumninews->foto)) {
                unlink($path . '/' . $alumninews->foto);
            }

            // Simpan file baru
            $file = $request->file('foto');
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);

            // Simpan nama file ke kolom
            $alumninews->foto = $filename;
        }

        $alumninews->save();

        return redirect()->route('admin.alumninews.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $alumninews = AlumniNews::findOrFail($id);
        $alumninews->delete();

        return redirect()->route('admin.alumninews.index')->with('success', 'Berita berhasil dihapus');
    }
}

