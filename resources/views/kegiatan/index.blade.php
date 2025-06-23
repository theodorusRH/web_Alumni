@extends('layouts.app')

@section('content')
<h2>Daftar Kegiatan</h2>

@auth
    @if(Auth::user()->isAdmin())
        <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-primary mb-3">Tambah Kegiatan Baru</a>
    @endif
@endauth

@if($kegiatan->isEmpty())
    <p>Belum ada kegiatan.</p>
@else
    @foreach($kegiatan as $item)
        <div class="list-group mb-3">
            <a href="{{ route('kegiatan.show', $item->id) }}" class="list-group-item list-group-item-action">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
                    <div>
                        <h5>{{ $item->judul }}</h5>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</small>
                    </div>
                    <div class="mt-2 mt-md-0 d-flex flex-wrap gap-2">
                        @if($item->filenames)
                            @foreach ($item->filenames as $filename)
                                <img src="{{ asset('images/kegiatan/' . $item->id . '/' . $filename) }}" width="150" height="100" style="object-fit: cover;" class="border rounded">
                            @endforeach
                        @elseif($item->foto)
                            <img src="{{ asset('images/kegiatan/' . $item->id . '/' . $item->foto) }}" width="150" height="100" style="object-fit: cover;" class="border rounded">
                        @endif
                    </div>
                </div>
            </a>

            @auth
                @if(Auth::user()->isAdmin())
                    <div class="mt-2">
                        <a href="{{ route('admin.kegiatan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.kegiatan.destroy', $item->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kegiatan ini?')">Hapus</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    @endforeach
@endif
@endsection
