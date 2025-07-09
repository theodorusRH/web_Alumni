@extends('layouts.app')

@section('content')
    <h1>Detail Mahasiswa</h1>

    <table cellpadding="6">
        <tr><th>NRP</th><td>{{ $mahasiswa->nrp }}</td></tr>
        <tr><th>Angkatan</th><td>{{ $mahasiswa->angkatan }}</td></tr>
        <tr><th>Nama</th><td>{{ $mahasiswa->nama }}</td></tr>
        <tr><th>Alamat</th><td>{{ $mahasiswa->alamat }}</td></tr>
        <tr><th>Kota</th><td>{{ $mahasiswa->kota }}</td></tr>
        <tr><th>Kode Pos</th><td>{{ $mahasiswa->kodepos }}</td></tr>
        <tr><th>Jenis Kelamin</th><td>{{ $mahasiswa->sex }}</td></tr>
        <tr><th>Email</th><td>{{ $mahasiswa->email }}</td></tr>
        <tr><th>Telepon</th><td>{{ $mahasiswa->telepon }}</td></tr>
        <tr><th>HP</th><td>{{ $mahasiswa->hp }}</td></tr>
        <tr><th>Tempat Lahir</th><td>{{ $mahasiswa->tmptlahir }}</td></tr>
        <tr><th>Tanggal Lahir</th><td>{{ $mahasiswa->tgllahir }}</td></tr>
        <tr><th>Provinsi</th><td>{{ $mahasiswa->propinsi->nama ?? '-' }}</td></tr>
    </table>

    <a href="{{ route('admin.mahasiswa.index') }}" style="margin-top: 20px; display: inline-block;">← Kembali ke Daftar</a>
@endsection
