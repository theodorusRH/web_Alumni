<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\Mahasiswa;
use App\Models\JenisPekerjaan;
use App\Models\Propinsi;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    // Menampilkan daftar pekerjaan berdasarkan NRP mahasiswa
    public function index($nrp = null)
    {
        if (!$nrp) {
            $mahasiswas = Mahasiswa::all();
            return view('pekerjaan.select_mahasiswa', compact('mahasiswas'));
        }

        $mahasiswa = Mahasiswa::findOrFail($nrp);
        $pekerjaans = $mahasiswa->pekerjaan()->with('jenisPekerjaan')->get();

        return view('pekerjaan.index', compact('mahasiswa', 'pekerjaans'));
    }

    // Form untuk tambah pekerjaan
    public function create($nrp)
    {
        $mahasiswa = Mahasiswa::findOrFail($nrp);
        $jenisPekerjaans = JenisPekerjaan::all();
        $propinsis = Propinsi::all();

        return view('pekerjaan.create', compact('mahasiswa', 'jenisPekerjaans', 'propinsis'));
    }

    // Simpan pekerjaan baru
    public function store(Request $request, $nrp)
    {
        $request->validate([
            'idjenispekerjaan' => 'required|exists:jenispekerjaan,idjenispekerjaan',
            'bidangusaha' => 'required|string|max:255',
            'perusahaan' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'mulaikerja' => 'nullable|date',
            'gajipertama' => 'nullable|numeric',
            'alamat' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:100',
            'kodepos' => 'nullable|string|max:10',
            'idpropinsi' => 'required|exists:propinsi,idpropinsi',
            'jabatan' => 'nullable|string|max:100',
        ]);

        $idjenispekerjaan = $request->idjenispekerjaan;
        $idpropinsi = $request->idpropinsi;

        // Cek duplikat berdasarkan composite key
        $existing = Pekerjaan::where('nrp', $nrp)
            ->where('idjenispekerjaan', $idjenispekerjaan)
            ->where('idpropinsi', $idpropinsi)
            ->first();

        if ($existing) {
            return redirect()->route('admin.pekerjaan.show', $nrp)
                ->with('error', 'Data pekerjaan dengan kombinasi yang sama sudah ada.');
        }

        $data = $request->all();
        $data['nrp'] = $nrp;

        Pekerjaan::create($data);

        return redirect()->route('admin.pekerjaan.show', $nrp)
            ->with('success', 'Data pekerjaan berhasil ditambahkan.');
    }


    // Update pekerjaan yang ada
    public function updatePekerjaan(Request $request, $nrp, $idjenispekerjaan, $idpropinsi)
    {
        $pekerjaan = Pekerjaan::where('nrp', $nrp)
            ->where('idjenispekerjaan', $idjenispekerjaan)
            ->where('idpropinsi', $idpropinsi)
            ->firstOrFail();

        $request->validate([
            'idjenispekerjaan' => 'required|exists:jenispekerjaan,idjenispekerjaan',
            'bidangusaha' => 'required|string|max:255',
            'perusahaan' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'mulaikerja' => 'nullable|date',
            'gajipertama' => 'nullable|numeric',
            'alamat' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:100',
            'kodepos' => 'nullable|string|max:10',
            'idpropinsi' => 'nullable|exists:propinsi,idpropinsi',
            'jabatan' => 'nullable|string|max:100',
        ]);

        $pekerjaan->update($request->all());

        return redirect()->route('admin.pekerjaan.show', $pekerjaan->nrp)
            ->with('success', 'Data pekerjaan berhasil diperbarui.');
    }

    // Hapus pekerjaan
    public function destroyPekerjaan($nrp, $idjenispekerjaan, $idpropinsi)
    {
        $pekerjaan = Pekerjaan::where('nrp', $nrp)
            ->where('idjenispekerjaan', $idjenispekerjaan)
            ->where('idpropinsi', $idpropinsi)
            ->firstOrFail();
        $nrp = $pekerjaan->nrp;
        $pekerjaan->delete();

        return redirect()->route('admin.pekerjaan.show', $nrp)
            ->with('success', 'Data pekerjaan berhasil dihapus.');
    }
}
