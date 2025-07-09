@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pendidikan - {{ $mahasiswa->nama }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('admin.pendidikan.create', $mahasiswa->nrp) }}" class="btn btn-success mb-3">Tambah Pendidikan</a>

    @if($pendidikans->isEmpty())
        <p>Tidak ada data pendidikan.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jurusan</th>
                    <th>Angkatan</th>
                    <th>Tanggal Lulus</th>
                    <th>Jumlah Semester</th>
                    <th>IPK</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendidikans as $pendidikan)
                <tr>
                    <td>{{ $pendidikan->jurusan->nama ?? '-' }}</td>
                    <td>{{ $pendidikan->angkatan }}</td>
                    <td>{{ $pendidikan->tanggallulus ? \Carbon\Carbon::parse($pendidikan->tanggallulus)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $pendidikan->jmlsemester ?? '-' }}</td>
                    <td>{{ $pendidikan->ipk ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @php
        $backToMahasiswa = Auth::user()->roles->name === 'admin'
            ? route('admin.mahasiswa.index')
            : route('dosen.mahasiswa.index');
    @endphp

    <a href="{{ $backToMahasiswa }}" class="btn btn-secondary mt-3">Kembali ke Mahasiswa</a>

</div>
@endsection