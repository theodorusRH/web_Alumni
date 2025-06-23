<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontak;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\DB;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kontak = Kontak::first(); // diasumsikan hanya 1 data
        return view('kontak.index', compact('kontak'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|email|max:100',
            'pesan' => 'required',
        ]);

        Pertanyaan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ]);

        return redirect()->route('kontak.index')->with('success', 'Pesan Anda berhasil dikirim.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'alamat' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:50',
            'telepon' => 'nullable|string|max:20',
            'lokasi' => 'nullable|string',
            'gps' => 'nullable|string',
            'website' => 'nullable|string|max:45',
            'instagram' => 'nullable|string|max:45',
            'twitter' => 'nullable|string|max:45',
        ]);

        $kontak = Kontak::first(); // diasumsikan hanya 1 data
        $kontak->update($request->all());

        return back()->with('success', 'Kontak berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
