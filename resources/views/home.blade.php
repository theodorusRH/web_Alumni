@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Berita Alumni</h2>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @forelse ($alumninews as $news)
            <div class="col">
                <div class="card h-100 text-center p-3">

                    <a href="{{ route('home.showhome', $news->idalumninews) }}" style="text-decoration: none; color: inherit;">
                        <div class="mb-3 mx-auto">
                            @if ($news->foto)
                                <img src="{{ asset('storage/' . $news->foto) }}" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;" alt="Gambar kegiatan">
                            @else
                                <div style="width: 100%; height: 150px; background-color: #e0e0e0; display: flex; 
                                    justify-content: center; align-items: center; color: #777; font-weight: 500;">
                                    Tidak ada gambar
                                </div>
                            @endif
                        </div>
                        <h5 class="card-title">{{ $news->judul }}</h5>
                        <p class="card-text">
                            {{ \Illuminate\Support\Str::limit(strip_tags($news->isi), 100, '...') }}
                        </p>
                    </a>

                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Belum ada kegiatan alumni.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
