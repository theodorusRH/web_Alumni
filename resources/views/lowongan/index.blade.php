@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Lowongan</h2>
    <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary mb-3">+ Tambah Lowongan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jabatan</th>
                <th>Perusahaan</th>
                <th>Kota</th>
                <th>Gaji</th>
                <th>Status</th>
                <th colspan="3" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lowongans as $l)
            <tr>
                <td>{{ $l->jabatan }}</td>
                <td>{{ $l->perusahaan->nama ?? '-' }}</td>
                <td>{{ $l->perusahaan->kota ?? '-' }}</td>
                <td>{{ $l->gajimin }} - {{ $l->gajimax }}</td>
                <td>
                    @if ($l->isapproved)
                        <span class="badge bg-success">Disetujui</span>
                    @else
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.lowongan.edit', $l->idlowongan) }}" class="btn btn-sm btn-warning">Edit</a>
                </td>
                <td>
                    <form action="{{ route('admin.lowongan.destroy', $l->idlowongan) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
                <td>
                    @if (!$l->isapproved)
                    <form action="{{ route('admin.lowongan.approve', $l->idlowongan) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-success" onclick="return confirm('Setujui lowongan ini?')">Setujui</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $lowongans->links() }}
    </div>
</div>
@endsection
