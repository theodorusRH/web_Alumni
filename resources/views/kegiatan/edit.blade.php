@extends('layouts.app')

@section('content')
<h2>Edit Kegiatan</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="judul" class="form-control" value="{{ $kegiatan->judul }}" required>
    </div>
    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ $kegiatan->tanggal ? \Carbon\Carbon::parse($kegiatan->tanggal)->format('Y-m-d') : '' }}" required>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" required>{{ $kegiatan->deskripsi }}</textarea>
    </div>
    <div class="mb-3">
        <label>Foto (opsional)</label>
        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">

        @if($kegiatan->foto)
            <p>
                <strong>Gambar saat ini:</strong><br>
                <img id="currentFoto" src="{{ asset('storage/' . $kegiatan->foto) }}" style="max-height: 120px;">
            </p>
        @endif

        <p>
            <img id="fotoPreview" style="max-height: 150px; display: none; margin-top: 10px;" alt="Preview Foto">
        </p>
    </div>
    <button class="btn btn-primary">Update</button>
</form>

<script>
    document.getElementById('fotoInput').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const preview = document.getElementById('fotoPreview');
        const currentFoto = document.getElementById('currentFoto');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            if (currentFoto) {
                currentFoto.style.display = 'none'; // sembunyikan gambar lama jika ada preview baru
            }
        } else {
            preview.style.display = 'none';
            if (currentFoto) {
                currentFoto.style.display = 'block'; // tampilkan kembali gambar lama kalau file dihapus
            }
        }
    });
</script>
@endsection
