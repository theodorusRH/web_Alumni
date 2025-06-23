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
        <img id="fotoPreview"
             class="img-thumbnail mt-2"
             style="max-height: 150px; display: none; cursor: pointer;"
             alt="Preview Foto"
             data-bs-toggle="modal" data-bs-target="#fotoModal"
             onclick="showModalImage(this.src)">
    </div>
    <button class="btn btn-success">Simpan</button>
</form>

{{-- Modal untuk tampilan besar --}}
<div class="modal fade" id="fotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="#" class="img-fluid rounded" alt="Foto Besar">
            </div>
        </div>
    </div>
</div>

{{-- Script Preview & Modal --}}
<script>
    function showModalImage(src) {
        document.getElementById('modalImage').src = src;
    }

    document.getElementById('fotoInput').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const preview = document.getElementById('fotoPreview');
        if (file) {
            const imageUrl = URL.createObjectURL(file);
            preview.src = imageUrl;
            preview.style.display = 'block';
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });
</script>
@endsection
