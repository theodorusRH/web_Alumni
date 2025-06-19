@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Lowongan dan Perusahaan</h2>

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

    <form action="{{ route('lowongan.store') }}" method="POST">
        @csrf

        <h4>Data Lowongan</h4>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" required></textarea>
        </div>

        <div class="mb-3">
            <label for="kualifikasi" class="form-label">Kualifikasi</label>
            <textarea class="form-control" name="kualifikasi" required></textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Gaji Min</label>
                <input type="number" class="form-control" name="gajimin" required>
            </div>
            <div class="col">
                <label class="form-label">Gaji Max</label>
                <input type="number" class="form-control" name="gajimax" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="tanggal" required>
            </div>
            <div class="col">
                <label class="form-label">Tanggal Berakhir</label>
                <input type="date" class="form-control" name="tanggal_max" required>
            </div>
        </div>

        <input type="hidden" name="kirim" id="kirim" value="offline">

        <h4>Data Perusahaan</h4>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Perusahaan</label>
            <input type="text" class="form-control" name="perusahaan[nama]" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="perusahaan[alamat]" required></textarea>
        </div>
        <div class="mb-3">
            <label for="kota" class="form-label">Kota</label>
            <input type="text" class="form-control" name="perusahaan[kota]" required>
        </div>
        <div class="mb-3">
            <label for="idpropinsi" class="form-label">Propinsi</label>
            <select class="form-control" name="perusahaan[idpropinsi]" required>
                <option value="">Pilih Propinsi</option>
                @foreach($propinsis as $propinsi)
                    <option value="{{ $propinsi->idpropinsi }}">{{ $propinsi->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" class="form-control" name="perusahaan[telepon]" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="perusahaan[email]" id="perusahaan_email">
            <small class="form-text text-muted">Isi email jika lamaran bisa dikirim via email</small>
        </div>
        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" name="perusahaan[website]">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>

    </form>
    @auth
        @if(Auth::user()->roles->name === 'alumni')
            <div class="text-center mb-4">
                <a href="{{ route('lowongan.mine') }}" class="btn btn-secondary">Kembali</a>
            </div>
        @elseif(Auth::user()->roles->name === 'admin')
            <div class="text-center mb-4">
                <a href="{{ route('lowongan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        @endif
    @endauth
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('perusahaan_email');
    const kirimInput = document.getElementById('kirim');

    function updateKirim() {
        kirimInput.value = emailInput.value.trim() !== '' ? 'email' : 'offline';
    }

    emailInput.addEventListener('input', updateKirim);
    emailInput.addEventListener('blur', updateKirim);
    updateKirim();
});
</script>
@endsection
