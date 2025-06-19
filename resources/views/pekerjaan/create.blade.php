@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Pekerjaan - {{ $mahasiswa->nama }}</h2>

    <form action="{{ route('admin.pekerjaan.store', $mahasiswa->nrp) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="idjenispekerjaan" class="form-label">Jenis Pekerjaan</label>
            <select name="idjenispekerjaan" id="idjenispekerjaan" class="form-control" required>
                <option value="">-- Pilih Jenis Pekerjaan --</option>
                @foreach($jenisPekerjaans as $jenis)
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
            <label for="kodepos" class="form-label">Kode Pos</label>
            <input type="text" name="kodepos" id="kodepos" class="form-control" value="{{ old('kodepos') }}">
            @error('kodepos')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="idpropinsi" class="form-label">Provinsi</label>
            <select name="idpropinsi" id="idpropinsi" class="form-control" required>
                <option value="">-- Pilih Provinsi --</option>
                @foreach($propinsis as $prov)
                <option value="{{ $prov->idpropinsi }}" {{ old('idpropinsi') == $prov->idpropinsi ? 'selected' : '' }}>
                    {{ $prov->nama }}
                </option>
                @endforeach
            </select>
            @error('idpropinsi')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ old('jabatan') }}">
            @error('jabatan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.pekerjaan.index', $mahasiswa->nrp) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
