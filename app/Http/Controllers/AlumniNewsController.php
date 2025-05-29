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

        $data = $request->all();
        $data['userid'] = Auth::user()->username ?? 'admin';
        $data['tanggalbuat'] = now();
        $data['isactive'] = 1;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('alumninews', 'public');
        }

        AlumniNews::create($data);

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
            // Hapus file lama jika ada
            if ($alumninews->foto && \Storage::disk('public')->exists($alumninews->foto)) {
                \Storage::disk('public')->delete($alumninews->foto);
            }

            // Simpan file baru
            $alumninews->foto = $request->file('foto')->store('alumninews', 'public');
        }

        // Simpan perubahan ke database
        $alumninews->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.alumninews.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $alumninews = AlumniNews::findOrFail($id);
        $alumninews->delete();

        return redirect()->route('admin.alumninews.index')->with('success', 'Berita berhasil dihapus');
    }
}

