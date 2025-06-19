@extends('layouts.app')

@section('content')

<div class="container">
    {{-- <pre>{{ dd($lowongans) }}</pre> --}}
    <h2 class="mb-4">Lowongan Saya</h2>
    <a href="{{ route('lowongan.create') }}" class="btn btn-primary mb-3">+ Tambah Lowongan</a>

    @if($lowongans->isEmpty())
        <p class="text-muted">Belum ada lowongan yang Anda buat.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jabatan</th>
                    <th>Perusahaan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowongans as $l)
                <tr>
                    <td>{{ $l->jabatan }}</td>
                    <td>{{ $l->perusahaan->nama ?? '-' }}</td>
                    <td>
                        @if($l->isapproved)
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('lowongan.edit', $l->idlowongan) }}" class="btn btn-sm btn-warning">Edit</a>
                        {{-- Bisa tambah tombol hapus jika perlu --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
