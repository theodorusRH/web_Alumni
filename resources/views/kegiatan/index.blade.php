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
                <h5>{{ $item->judul }}</h5>
                <small>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</small>
                @if($item->filenames)
                @foreach ($item->filenames as $filename)
                <div>
                    <img height='100px' width='150px' src="{{ asset('images/kegiatan/' . $item->id . '/' . $filename) }}" />
                    {{-- <img src="{{ asset('storage/' . $news->foto) }}" style="max-height: 100px; margin-top: 10px;" alt="Foto berita"> --}}
                </div>
                @endforeach
                @endif
            </a>

            @auth
                @if(Auth::user()->isAdmin())
                    <div class="mt-1">
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
