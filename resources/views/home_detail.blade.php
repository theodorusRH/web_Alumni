@extends('layouts.app')

@section('content')
<h2>{{ $alumninews->judul }}</h2>
<p><small>{{ \Carbon\Carbon::parse($alumninews->tanggalbuat)->format('d M Y') }}</small></p>

@if ($alumninews->foto)
    <img src="{{ asset('storage/' . $alumninews->foto) }}" class="img-fluid mb-3" style="max-width: 100%; height: auto;" alt="Foto berita">
@endif

<p>{!! nl2br(e($alumninews->isi)) !!}</p>

@endsection
