@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Lowongan dan Perusahaan</h2>

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- <form action="{{ route('admin.lowongan.update', $lowongan->idlowongan) }}" method="POST"> --}}
    <form action="{{ Auth::user()->roles->name === 'admin' 
            ? route('admin.lowongan.update', $lowongan->idlowongan) 
            : route('lowongan.update', $lowongan->idlowongan) }}" method="POST">
        @csrf
        @method('PUT')

        <h4>Data Lowongan</h4>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" value="{{ old('jabatan', $lowongan->jabatan) }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" required>{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="kualifikasi" class="form-label">Kualifikasi</label>
            <textarea class="form-control" name="kualifikasi" required>{{ old('kualifikasi', $lowongan->kualifikasi) }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Gaji Min</label>
                <input type="number" class="form-control" name="gajimin" value="{{ old('gajimin', $lowongan->gajimin) }}" required>
            </div>
            <div class="col">
                <label class="form-label">Gaji Max</label>
                <input type="number" class="form-control" name="gajimax" value="{{ old('gajimax', $lowongan->gajimax) }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="tanggal" 
                    value="{{ old('tanggal', $lowongan->tanggal ? \Carbon\Carbon::parse($lowongan->tanggal)->format('Y-m-d') : '') }}" required>
            </div>
            <div class="col">
                <label class="form-label">Tanggal Berakhir</label>
                <input type="date" class="form-control" name="tanggal_max" 
                    value="{{ old('tanggal_max', $lowongan->tanggal_max ? \Carbon\Carbon::parse($lowongan->tanggal_max)->format('Y-m-d') : '') }}" required>
            </div>
        </div>

        <!-- Field Kirim (tersembunyi) -->
        <input type="hidden" name="kirim" id="kirim" value="{{ old('kirim', $lowongan->kirim) }}">

        <h4>Data Perusahaan</h4>
        <input type="hidden" name="idperusahaan" value="{{ $lowongan->perusahaan->idperusahaan }}">

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Perusahaan</label>
            <input type="text" class="form-control" name="perusahaan[nama]" value="{{ old('perusahaan.nama', $lowongan->perusahaan->nama) }}" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="perusahaan[alamat]" required>{{ old('perusahaan.alamat', $lowongan->perusahaan->alamat) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="kota" class="form-label">Kota</label>
            <input type="text" class="form-control" name="perusahaan[kota]" value="{{ old('perusahaan.kota', $lowongan->perusahaan->kota) }}" required>
        </div>
        <!-- Field Propinsi -->
        <div class="mb-3">
            <label for="idpropinsi" class="form-label">Propinsi</label>
            <select class="form-control" name="perusahaan[idpropinsi]" required>
                <option value="">Pilih Propinsi</option>
                @foreach($propinsis as $propinsi)
                    <option value="{{ $propinsi->idpropinsi }}" 
                        {{ old('perusahaan.idpropinsi', $lowongan->perusahaan->idpropinsi) == $propinsi->idpropinsi ? 'selected' : '' }}>
                        {{ $propinsi->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" class="form-control" name="perusahaan[telepon]" value="{{ old('perusahaan.telepon', $lowongan->perusahaan->telepon) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="perusahaan[email]" id="perusahaan_email" value="{{ old('perusahaan.email', $lowongan->perusahaan->email) }}">
            <small class="form-text text-muted">Isi email jika lamaran bisa dikirim via email</small>
        </div>
        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" name="perusahaan[website]" value="{{ old('perusahaan.website', $lowongan->perusahaan->website) }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
    @auth
        @if(Auth::user()->roles->name === 'alumni')
            <div class="text-center mb-4">
                <a href="{{ route('lowongan.mine') }}" class="btn btn-secondary">Kembali</a>
            </div>
        @elseif(Auth::user()->roles->name === 'admin')
            <div class="text-center mb-4">
                <a href="{{ route('admin.lowongan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        @endif
    @endauth
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('perusahaan_email');
    const kirimInput = document.getElementById('kirim');
    
    function updateKirim() {
        if (emailInput.value.trim() !== '') {
            kirimInput.value = 'email';
        } else {
            kirimInput.value = 'offline';
        }
    }
    
    // Update saat user mengetik di field email
    emailInput.addEventListener('input', updateKirim);
    emailInput.addEventListener('blur', updateKirim);
    
    // Set nilai awal berdasarkan email yang sudah ada
    updateKirim();
});
</script>
@endsection