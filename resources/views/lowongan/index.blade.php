@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Lowongan</h2>
    <a href="{{ route('admin.lowongan.create') }}" class="btn btn-primary mb-3">+ Tambah Lowongan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jabatan</th>
                <th>Perusahaan</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Website</th>
                <th>Gaji</th>
                <th colspan="2" class="text-center">Aksi</th> <!-- merge 2 kolom -->
            </tr>
        </thead>
        <tbody>
            @foreach ($lowongans as $l)
            <tr>
                <td>{{ $l->jabatan }}</td>
                <td>{{ $l->perusahaan->nama ?? '-' }}</td>
                <td>{{ $l->perusahaan->alamat ?? '-' }}</td>
                <td>{{ $l->perusahaan->kota ?? '-' }}</td>
                <td>{{ $l->perusahaan->telepon ?? '-' }}</td>
                <td>{{ $l->perusahaan->email ?? '-' }}</td>
                <td>
                    @if (!empty($l->perusahaan->website))
                        <a href="{{ $l->perusahaan->website }}" target="_blank">{{ $l->perusahaan->website }}</a>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $l->gajimin }} - {{ $l->gajimax }}</td>
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
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination links --}}
    <div class="d-flex justify-content-center">
        {{ $lowongans->links() }}
    </div>
</div>
@endsection
