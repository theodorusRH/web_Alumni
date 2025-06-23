@extends('layouts.app')

@section('content')
<h2>Berita Alumni</h2>

@auth
    @if(Auth::user()->isAdmin())
        <a href="{{ route('admin.alumninews.create') }}" class="btn btn-primary mb-3">Tambah Berita Alumni</a>
    @endif
@endauth

@if($alumninews->isEmpty())
    <p>Belum ada berita alumni.</p>
@else
    @foreach($alumninews as $news)
        <div class="list-group mb-3">
            <a href="{{ route('alumninews.show', $news->idalumninews) }}" class="list-group-item list-group-item-action">
                <h5>{{ $news->judul }}</h5>
                <small>{{ \Carbon\Carbon::parse($news->tanggalbuat)->format('d M Y') }}</small>
                @if($news->filenames)
                @foreach ($news->filenames as $filename)
                <div>
                    <img height='100px' width='150px' src="{{ asset('images/alumninews/' . $news->idalumninews . '/' . $filename) }}" />
                    {{-- <img src="{{ asset('storage/' . $news->foto) }}" style="max-height: 100px; margin-top: 10px;" alt="Foto berita"> --}}
                </div>
                @endforeach
                @endif
            </a>

            @auth
                @if(Auth::user()->isAdmin())
                    <div class="mt-1">
                        <a href="{{ route('admin.alumninews.edit', $news->idalumninews) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.alumninews.destroy', $news->idalumninews) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    @endforeach

    {{-- Pagination links --}}
    {{ $alumninews->links() }}
@endif
@endsection
