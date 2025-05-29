@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Lowongan Kerja</h2>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @forelse ($lowongans as $l)
            <div class="col">
                <div class="card h-100 p-3">

                    <a href="{{ route('lowongan.index', $l->idlowongan) }}" style="text-decoration: none; color: inherit;">
                        <h5 class="card-title">{{ $l->jabatan }}</h5>
                        <p class="card-text">
                            {{ \Illuminate\Support\Str::limit(strip_tags($l->deskripsi), 100, '...') }}
                        </p>
                        <p><strong>Perusahaan:</strong> {{ $l->perusahaan->nama ?? '-' }}</p>
                        <p><strong>Alamat:</strong> {{ $l->perusahaan->alamat ?? '-' }}</p>
                        <p><strong>Kota:</strong> {{ $l->perusahaan->kota ?? '-' }}</p>
                        <p><strong>Telepon:</strong> {{ $l->perusahaan->telepon ?? '-' }}</p>
                        <p><strong>Email:</strong> {{ $l->perusahaan->email ?? '-' }}</p>
                        <p><strong>Website:</strong> 
                            @if (!empty($l->perusahaan->website))
                                <a href="{{ $l->perusahaan->website }}" target="_blank">{{ $l->perusahaan->website }}</a>
                            @else
                                -
                            @endif
                        </p>
                        <p><strong>Gaji:</strong> {{ $l->gajimin }} - {{ $l->gajimax }}</p>
                    </a>

                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Belum ada lowongan tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
