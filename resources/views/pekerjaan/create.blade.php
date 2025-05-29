@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Pekerjaan - {{ $mahasiswa->nama }}</h2>

    <form action="{{ route('pekerjaan.store', $mahasiswa->nrp) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="idjenispekerjaan" class="form-label">Jenis Pekerjaan</label>
            <select name="idjenispekerjaan" id="idjenispekerjaan" class="form-control" required>
                <option value="">-- Pilih Jenis Pekerjaan --</option>
                @foreach(\App\Models\JenisPekerjaan::all() as $jenis)
                <option value="{{ $jenis->idjenispekerjaan }}" {{ old('idjenispekerjaan') == $jenis->idjenispekerjaan ? 'selected' : '' }}>
                    {{ $jenis->nama }}
                </option>
                @endforeach
            </select>
            @error('idjenispekerjaan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="bidangusaha" class="form-label">Bidang Usaha</label>
            <input type="text" name="bidangusaha" id="bidangusaha" class="form-control" value="{{ old('bidangusaha') }}" required>
            @error('bidangusaha')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="perusahaan" class="form-label">Perusahaan</label>
            <input type="text" name="perusahaan" id="perusahaan" class="form-control" value="{{ old('perusahaan') }}">
            @error('perusahaan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon') }}">
            @error('telepon')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="mulaikerja" class="form-label">Mulai Kerja</label>
            <input type="date" name="mulaikerja" id="mulaikerja" class="form-control" value="{{ old('mulaikerja') }}">
            @error('mulaikerja')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="gajipertama" class="form-label">Gaji Pertama</label>
            <input type="number" name="gajipertama" id="gajipertama" class="form-control" value="{{ old('gajipertama') }}">
            @error('gajipertama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat') }}</textarea>
            @error('alamat')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kota" class="form-label">Kota</label>
            <input type="text" name="kota" id="kota" class="form-control" value="{{ old('kota') }}">
            @error('kota')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <
