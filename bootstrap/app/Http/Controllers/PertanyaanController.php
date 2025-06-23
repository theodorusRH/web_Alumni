<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Kontak;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\DB;

class PertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pertanyaans = Pertanyaan::latest()->paginate(10);
        return view('pertanyaan.index', compact('pertanyaans'));
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

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $pertanyaan = Pertanyaan::findOrFail($id);
        // $pertanyaan->isread = true;
        // $pertanyaan->save();

        // return view('admin.pertanyaan.show', compact('pertanyaan'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Pertanyaan::findOrFail($id);
        $data->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
