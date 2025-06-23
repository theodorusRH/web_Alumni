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

    {{-- Input Judul --}}
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="judul" class="form-control" value="{{ $kegiatan->judul }}" required>
    </div>

    {{-- Input Tanggal --}}
    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ $kegiatan->tanggal ? \Carbon\Carbon::parse($kegiatan->tanggal)->format('Y-m-d') : '' }}" required>
    </div>

    {{-- Input Deskripsi --}}
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control" required>{{ $kegiatan->deskripsi }}</textarea>
    </div>

    {{-- Tampilkan Foto Lama --}}
    <div class="mb-3">
        <label>Foto Lama</strong></label><br>
        @if($kegiatan->foto)
            <img src="{{ asset('images/kegiatan/' . $kegiatan->id . '/' . $kegiatan->foto) }}"
                class="img-thumbnail mb-2" width="200" id="currentFoto"
                style="cursor:pointer"
                data-bs-toggle="modal" data-bs-target="#fotoLamaModal">
        @else
            <p class="text-muted">Tidak ada foto.</p>
        @endif
    </div>

    {{-- Modal Foto Lama --}}
    @if($kegiatan->foto)
    <div class="modal fade" id="fotoLamaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="{{ asset('images/kegiatan/' . $kegiatan->id . '/' . $kegiatan->foto) }}"
                        class="img-fluid rounded" alt="Foto Lama">
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Upload Foto Baru --}}
    <div class="mb-3">
        <label>Ganti / Tambah Foto Baru (opsional)</label>
        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
        <div class="mt-2" id="previewContainer" class="d-flex flex-wrap gap-2">
            <img id="previewImage" class="img-thumbnail mt-2" style="max-height: 120px; display: none; cursor: pointer;" 
                data-bs-toggle="modal" data-bs-target="#fotoBaruModal">
        </div>
    </div>

    {{-- Modal Foto Baru --}}
    <div class="modal fade" id="fotoBaruModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalFotoBaru" src="#" class="img-fluid rounded" alt="Preview Foto Baru">
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary">Update</button>
</form>

{{-- Script Preview Foto --}}
<script>
    document.getElementById('fotoInput').addEventListener('change', function (event) {
        const previewImage = document.getElementById('previewImage');
        const modalImage = document.getElementById('modalFotoBaru');
        const currentFoto = document.getElementById('currentFoto');
        const file = event.target.files[0];

        if (file) {
            const imageUrl = URL.createObjectURL(file);
            previewImage.src = imageUrl;
            modalImage.src = imageUrl;
            previewImage.style.display = 'block';
        } else {
            previewImage.style.display = 'none';
            modalImage.src = '#';
            if (currentFoto) {
                currentFoto.style.display = 'block';
            }
        }
    });
</script>
@endsection
