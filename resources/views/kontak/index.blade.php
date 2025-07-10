@extends('layouts.app')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')
<div class="container py-5">
    <div class="row text-center mb-4">
        <h2 class="fw-bold">Hubungi Kami</h2>
        <p class="text-muted">Kunjungi kampus atau hubungi kami secara online.</p>
    </div>

    <div class="row align-items-start">
        {{-- Kiri: Info Kampus --}}
        <div class="col-md-6 mb-4">
            <h4 class="mb-3">Kunjungi Kami Di Kampus<br><span class="text-primary">UBAYA Rungkut</span></h4>
            <p>{{ $kontak->alamat }}</p>
            <a href="{{ $kontak->gps }}" class="text-warning text-decoration-none fw-semibold" target="_blank">
                Get Directions
            </a>
            <div class="mt-4">
                <img src="{{ asset('images/kontak/ifubaya.png') }}" alt="Logo UBAYA" width="200" height="100">
                <p class="mt-2 text-muted small">{{ $kontak->email }}</p>

                {{-- <div class="mt-4 text-center">
                    <a href="https://alumni.ubaya.ac.id" title="Alumni Universitas Surabaya" rel="home">
                        <img src="{{ asset('images/kontak/' . $kontak->foto) }}"
                            alt="Alumni Universitas Surabaya" width="100">
                    </a>
                    <div class="mt-2 text-muted small">
                        <a href="mailto:{{ $kontak->email }}" class="text-muted text-decoration-none">
                            {{ $kontak->email }}
                        </a>
                    </div>
                </div> --}}

                <div class="mt-2">
                    <a href="{{ $kontak->instagram }}" class="text-dark me-2" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $kontak->twitter }}" class="text-dark" target="_blank"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>

        {{-- Kanan: Form Pertanyaan --}}
        <div class="col-md-6">
            <h4 class="mb-3">Kirim Pertanyaan</h4>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('kontak.kirim') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan</label>
                    <textarea class="form-control" id="pesan" name="pesan" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
</div>
@endsection