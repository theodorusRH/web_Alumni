@extends('layouts.app')

@section('content')
<h2>{{ $kegiatan->judul }}</h2>
<p><small>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}</small></p>

@if ($kegiatan->foto)
    <img src="{{ asset('storage/' . $kegiatan->foto) }}" alt="Foto kegiatan" class="img-fluid mb-4" style="max-width: 100%; height: auto;">
@endif

<p>{!! nl2br(e($kegiatan->deskripsi)) !!}</p>

<a href="{{ url('/kegiatan') }}" class="btn btn-secondary mt-3">Kembali ke daftar kegiatan</a>
@endsection
