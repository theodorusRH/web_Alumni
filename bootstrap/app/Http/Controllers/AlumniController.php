<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use App\Models\Perusahaan;
use App\Models\Lowongan;
use App\Models\AlumniNews;
use App\Models\Propinsi;
use App\Models\Jurusan;
use App\Models\JenisPekerjaan;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    // Halaman dashboard statistik dan berita aktif
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalAlumni = Mahasiswa::whereHas('pendidikan', fn($q) => $q->whereNotNull('tanggallulus'))->count();
        $totalBekerja = Pekerjaan::count();
        $totalPerusahaan = Perusahaan::where('isactive', 1)->count();
        $news = AlumniNews::where('isactive', 1)->orderBy('tanggalbuat', 'desc')->take(5)->get();

        return view('alumni.index', compact('totalMahasiswa', 'totalAlumni', 'totalBekerja', 'totalPerusahaan', 'news'));
    }

    // Mahasiswa CRUD
    public function mahasiswa()
    {
        $mahasiswa = Mahasiswa::with('propinsi')->orderBy('nama')->paginate(15);
        $propinsi = Propinsi::where('isactive', 1)->get();

        return view('alumni.mahasiswa', compact('mahasiswa', 'propinsi'));
    }

    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'nrp' => 'required|unique:mahasiswa,nrp',
            'nama' => 'required',
            'email' => 'required|email',
            'idpropinsi' => 'required'
        ]);

        Mahasiswa::create($request->all());

        return redirect()->back()->with('success', 'Data mahasiswa berhasil ditambahkan');
    }

    public function updateMahasiswa(Request $request, $nrp)
    {
        $mahasiswa = Mahasiswa::findOrFail($nrp);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'idpropinsi' => 'required'
        ]);

        $mahasiswa->update($request->all());

        return redirect()->back()->with('success', 'Data mahasiswa berhasil diupdate');
    }

    public function destroyMahasiswa($nrp)
    {
        $mahasiswa = Mahasiswa::findOrFail($nrp);
        $mahasiswa->delete();

        return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus');
    }

    // Alumni listing
    public function alumni()
    {
        $alumni = Mahasiswa::with(['pendidikan.jurusan', 'pekerjaan'])
                          ->whereHas('pendidikan', fn($q) => $q->whereNotNull('tanggallulus'))
                          ->orderBy('nama')
                          ->paginate(15);

        return view('alumni.alumni', compact('alumni'));
    }

    // Pekerjaan CRUD
    public function pekerjaan()
    {
        $pekerjaan = Pekerjaan::with(['mahasiswa', 'jenisPekerjaan', 'propinsi'])
                             ->orderBy('mulaikerja', 'desc')
                             ->paginate(15);

        $mahasiswa = Mahasiswa::orderBy('nama')->get();
        $jenisPekerjaan = JenisPekerjaan::all();
        $propinsi = Propinsi::where('isactive', 1)->get();

        return view('alumni.pekerjaan', compact('pekerjaan', 'mahasiswa', 'jenisPekerjaan', 'propinsi'));
    }

    public function storePekerjaan(Request $request)
    {
        $request->validate([
            'nrp' => 'required',
            'idjenispekerjaan' => 'required',
            'perusahaan' => 'required',
            'jabatan' => 'required',
            'idpropinsi' => 'required'
        ]);

        Pekerjaan::create($request->all());

        return redirect()->back()->with('success', 'Data pekerjaan berhasil ditambahkan');
    }

    // Perusahaan CRUD
    public function perusahaan()
    {
        $perusahaan = Perusahaan::with('propinsi')->where('isactive', 1)->orderBy('nama')->paginate(15);
        $propinsi = Propinsi::where('isactive', 1)->get();

        return view('alumni.perusahaan', compact('perusahaan', 'propinsi'));
    }

    public function storePerusahaan(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
            'idpropinsi' => 'required'
        ]);

        $data = $request->all();
        $data['userid'] = Auth::user()->username ?? 'admin';

        Perusahaan::create($data);

        return redirect()->back()->with('success', 'Data perusahaan berhasil ditambahkan');
    }

    // Lowongan kerja CRUD
    public function lowongan()
    {
        $lowongan = Lowongan::with('perusahaan')->where('isactive', 1)->orderBy('tanggal', 'desc')->paginate(15);
        $perusahaan = Perusahaan::where('isactive', 1)->orderBy('nama')->get();

        return view('alumni.lowongan', compact('lowongan', 'perusahaan'));
    }

    public function storeLowongan(Request $request)
    {
        $request->validate([
            'jabatan' => 'required',
            'idperusahaan' => 'required',
            'deskripsi' => 'required',
            'kualifikasi' => 'required'
        ]);

        $data = $request->all();
        $data['userid'] = Auth::user()->username ?? 'admin';
        $data['tanggal'] = now();

        Lowongan::create($data);

        return redirect()->back()->with('success', 'Lowongan kerja berhasil ditambahkan');
    }

    // Berita alumni
    public function storeNews(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required'
        ]);

        $data = $request->all();
        $data['userid'] = Auth::user()->username ?? 'admin';
        $data['tanggalbuat'] = now();

        AlumniNews::create($data);

        return redirect()->back()->with('success', 'Berita berhasil ditambahkan');
    }

    // Laporan statistik alumni
    public function laporan()
    {
        $data = [
            'totalMahasiswa' => Mahasiswa::count(),
            'totalAlumni' => Mahasiswa::whereHas('pendidikan', fn($q) => $q->whereNotNull('tanggallulus'))->count(),
            'totalBekerja' => Pekerjaan::count(),
            'totalPerusahaan' => Perusahaan::where('isactive', 1)->count(),
            'alumniPerJurusan' => Jurusan::withCount(['pendidikan' => fn($q) => $q->whereNotNull('tanggallulus')])->get(),
            'alumniPerTahun' => Pendidikan::whereNotNull('tanggallulus')
                                         ->selectRaw('YEAR(tanggallulus) as tahun, COUNT(*) as jumlah')
                                         ->groupBy('tahun')
                                         ->orderBy('tahun', 'desc')
                                         ->get()
        ];

        return view('alumni.laporan', compact('data'));
    }

    // API endpoints for AJAX calls (JSON)
    public function getMahasiswa()
    {
        $mahasiswa = Mahasiswa::with('propinsi')->orderBy('nama')->get();
        return response()->json($mahasiswa);
    }

    public function getAlumni()
    {
        $alumni = Mahasiswa::with(['pendidikan.jurusan', 'pekerjaan'])
                          ->whereHas('pendidikan', fn($q) => $q->whereNotNull('tanggallulus'))
                          ->orderBy('nama')->get();

        return response()->json($alumni);
    }

    public function getPekerjaan()
    {
        $pekerjaan = Pekerjaan::with(['mahasiswa', 'jenisPekerjaan', 'propinsi'])->orderBy('mulaikerja', 'desc')->get();
        return response()->json($pekerjaan);
    }

    public function getPerusahaan()
    {
        $perusahaan = Perusahaan::with('propinsi')->where('isactive', 1)->orderBy('nama')->get();
        return response()->json($perusahaan);
    }

    public function getLowongan()
    {
        $lowongan = Lowongan::with('perusahaan')->where('isactive', 1)->orderBy('tanggal', 'desc')->get();
        return response()->json($lowongan);
    }
}
