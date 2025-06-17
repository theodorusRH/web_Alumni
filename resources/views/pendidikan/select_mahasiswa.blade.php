@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pilih Mahasiswa untuk Melihat Data Pendidikan</h2>

    @if($mahasiswas->isEmpty())
        <div class="alert alert-info">Tidak ada data mahasiswa.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NRP</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Kota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswas as $mhs)
                <tr>
                    <td>{{ $mhs->nrp }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->email ?? '-' }}</td>
                    <td>{{ $mhs->kota ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.pendidikan.show', $mhs->nrp) }}" class="btn btn-primary btn-sm">
                            Lihat Pendidikan
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection