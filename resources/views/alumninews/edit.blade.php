@extends('layouts.app')

@section('content')
<h2>Edit Berita Alumni</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.alumninews.update', $alumninews->idalumninews) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="judul" class="form-control" value="{{ $alumninews->judul }}" required>
    </div>
    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ \Carbon\Carbon::parse($alumninews->tanggal)->format('Y-m-d') }}" required>
    </div>
    <div class="mb-3">
        <label>Isi</label>
        <textarea name="isi" class="form-control" required>{{ $alumninews->isi }}</textarea>
    </div>
    <div class="mb-3">
        <label>Foto (opsional)</label>
        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">

        @if($alumninews->foto)
            <p>
                <strong>Gambar saat ini:</strong><br>
                <img id="currentFoto" src="{{ asset('storage/' . $alumninews->foto) }}" style="max-height: 120px;">
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
                currentFoto.style.display = 'none';
            }
        } else {
            preview.style.display = 'none';
            if (currentFoto) {
                currentFoto.style.display = 'block';
            }
        }
    });
</script>
@endsection
