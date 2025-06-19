@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Pendidikan - {{ $mahasiswa->nama }}</h2>

    <form action="{{ route('admin.pendidikan.store', $mahasiswa->nrp) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="idjurusan" class="form-label">Jurusan</label>
            <select name="idjurusan" id="idjurusan" class="form-control" required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach($jurusans as $jurusan)
                <option value="{{ $jurusan->idjurusan }}" {{ old('idjurusan') == $jurusan->idjurusan ? 'selected' : '' }}>
                    {{ $jurusan->nama }}
                </option>
                @endforeach
            </select>
            @error('idjurusan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="angkatan" class="form-label">Angkatan</label>
            <input type="number" name="angkatan" id="angkatan" class="form-control" value="{{ old('angkatan') }}" required>
            @error('angkatan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggallulus" class="form-label">Tanggal Lulus</label>
            <input type="date" name="tanggallulus" id="tanggallulus" class="form-control" value="{{ old('tanggallulus') }}">
            @error('tanggallulus')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jmlsemester" class="form-label">Jumlah Semester</label>
            <input type="number" name="jmlsemester" id="jmlsemester" class="form-control" value="{{ old('jmlsemester') }}">
            @error('jmlsemester')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="ipk" class="form-label">IPK</label>
            <input type="text" name="ipk" id="ipk" class="form-control" value="{{ old('ipk') }}">
            @error('ipk')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.pendidikan.index', $mahasiswa->nrp) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
