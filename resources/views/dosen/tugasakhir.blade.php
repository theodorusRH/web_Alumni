@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Daftar Tugas Akhir yang Dibimbing</h4>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>NRP</th>
                <th>Nama Mahasiswa</th>
                <th>Judul TA</th>
                <th>Nilai</th>
                <th>Tanggal Lulus</th>
            </tr>
        </thead>
        <tbody>
            @forelse($daftarTA as $ta)
                <tr>
                    <td>{{ $ta->nrp }}</td>
                    <td>{{ $ta->mahasiswa->nama ?? '-' }}</td>
                    <td>{{ $ta->judul }}</td>
                    <td>{{ $ta->nilai_ta }}</td>
                    <td>{{ $ta->tanggal_lulus_ta ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada TA yang dibimbing</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection