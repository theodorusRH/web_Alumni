<?php
namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
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


    public function storePekerjaan(Request $request)
    {
        $request->validate([
            'nrp' => 'required|exists:mahasiswa,nrp',
            'idjenispekerjaan' => 'required|exists:jenis_pekerjaan,idjenispekerjaan',
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

        Pekerjaan::create($request->all());

        return redirect()->route('admin.pekerjaan.index', $request->nrp)
            ->with('success', 'Data pekerjaan berhasil ditambahkan');
    }

    public function updatePekerjaan(Request $request, $id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        
        $request->validate([
            'idjenispekerjaan' => 'required|exists:jenis_pekerjaan,idjenispekerjaan',
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

        return redirect()->route('admin.pekerjaan.index', $pekerjaan->nrp)
            ->with('success', 'Data pekerjaan berhasil diupdate');
    }

    public function destroyPekerjaan($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $nrp = $pekerjaan->nrp;
        $pekerjaan->delete();

        return redirect()->route('admin.pekerjaan.index', $nrp)
            ->with('success', 'Data pekerjaan berhasil dihapus');
    }
}