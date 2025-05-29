<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    public function index($nrp)
    {
        $mahasiswa = Mahasiswa::findOrFail($nrp);
        $pekerjaans = $mahasiswa->pekerjaan()->with('jenisPekerjaan')->get();

        return view('pekerjaan.index', compact('mahasiswa', 'pekerjaans'));
    }

    public function create($nrp)
    {
        $mahasiswa = Mahasiswa::findOrFail($nrp);
        $propinsis = \App\Models\Propinsi::all();

        return view('pekerjaan.create', compact('mahasiswa', 'propinsis'));
    }

    public function store(Request $request, $nrp)
    {
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

        $data = $request->all();
        $data['nrp'] = $nrp;

        Pekerjaan::create($data);

        return redirect()->route('pekerjaan.index', $nrp)
            ->with('success', 'Data pekerjaan berhasil ditambahkan');
    }

    public function show($id)
    {
        $pekerjaan = Pekerjaan::with('jenisPekerjaan', 'mahasiswa', 'propinsi')->findOrFail($id);

        return view('pekerjaan.show', compact('pekerjaan'));
    }

    public function edit($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $propinsis = \App\Models\Propinsi::all();

        return view('pekerjaan.edit', compact('pekerjaan', 'propinsis'));
    }

    public function update(Request $request, $id)
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

        return redirect()->route('pekerjaan.show', $id)
            ->with('success', 'Data pekerjaan berhasil diupdate');
    }

    public function destroy($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjaan->delete();

        return redirect()->back()->with('success', 'Data pekerjaan berhasil dihapus');
    }
}
