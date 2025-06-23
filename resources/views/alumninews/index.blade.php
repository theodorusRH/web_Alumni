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
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
                    <div>
                        <h5>{{ $news->judul }}</h5>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($news->tanggalbuat)->format('d M Y') }}</small>
                    </div>
                    <div class="mt-2 mt-md-0 d-flex flex-wrap gap-2">
                        @if($news->filenames)
                            @foreach ($news->filenames as $filename)
                                <img src="{{ asset('images/alumninews/' . $news->idalumninews . '/' . $filename) }}" width="150" height="100" style="object-fit: cover;" class="border rounded">
                            @endforeach
                        @elseif($news->foto)
                            <img src="{{ asset('images/alumninews/' . $news->idalumninews . '/' . $news->foto) }}" width="150" height="100" style="object-fit: cover;" class="border rounded">
                        @endif
                    </div>
                </div>
            </a>

            @auth
                @if(Auth::user()->isAdmin())
                    <div class="mt-2">
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
