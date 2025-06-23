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
        <input type="date" name="tanggal" class="form-control"
            value="{{ \Carbon\Carbon::parse($alumninews->tanggalbuat)->format('Y-m-d') }}" required>
    </div>

    <div class="mb-3">
        <label>Isi</label>
        <textarea name="isi" class="form-control" rows="5" required>{{ $alumninews->isi }}</textarea>
    </div>

    {{-- Foto Lama --}}
    <div class="mb-3">
        <label>Foto Lama</strong></label><br>
        @if($alumninews->foto)
            <img src="{{ asset('images/alumninews/' . $alumninews->idalumninews . '/' . $alumninews->foto) }}"
                class="img-thumbnail mb-2" width="200"
                style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#fotoModal"
                onclick="showModalImage(this.src)">
        @else
            <p class="text-muted">Tidak ada foto.</p>
        @endif
    </div>

    {{-- Foto Baru --}}
    <div class="mb-3">
        <label>Ganti / Tambah Foto Baru (opsional)</label>
        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*" multiple>
        <div class="mt-2 d-flex flex-wrap gap-2" id="previewContainer"></div>
    </div>

    <button class="btn btn-primary">Update</button>
</form>

{{-- Modal Preview Gambar Besar --}}
<div class="modal fade" id="fotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="#" class="img-fluid rounded" alt="Preview Besar">
            </div>
        </div>
    </div>
</div>

{{-- Script Preview + Zoom --}}
<script>
    function showModalImage(src) {
        const modalImg = document.getElementById('modalImage');
        modalImg.src = src;
    }

    document.getElementById('fotoInput').addEventListener('change', function (event) {
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = '';
        const files = event.target.files;

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxHeight = '120px';
                img.style.marginRight = '10px';
                img.classList.add('img-thumbnail', 'mb-2');
                img.style.cursor = 'pointer';
                img.setAttribute('data-bs-toggle', 'modal');
                img.setAttribute('data-bs-target', '#fotoModal');
                img.onclick = () => showModalImage(e.target.result);

                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection
