@extends('layouts.app')

@section('content')
<h2>Tambah Berita Alumni</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.alumninews.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="judul" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Isi</label>
        <textarea name="isi" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label>Foto (opsional)</label>
        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
        <img id="fotoPreview" style="max-height: 150px; display: none; margin-top: 10px;" alt="Preview Foto">
    </div>
    <button class="btn btn-success">Simpan</button>
</form>

<script>
    document.getElementById('fotoInput').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('fotoPreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>
@endsection
