@extends('layouts.app')

@section('content')
<h2>Tambah Kegiatan</h2>

@auth
    @if(Auth::user()->isAdmin())
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.kegiatan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required></textarea>
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

        {{-- Modal untuk pembesaran gambar --}}
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
    @else
        <div class="alert alert-danger">
            <p>Anda tidak memiliki akses untuk menambah kegiatan.</p>
        </div>
    @endif
@else
    <div class="alert alert-warning">
        <p>Silakan <a href="{{ route('login') }}">login</a> terlebih dahulu untuk mengakses halaman ini.</p>
    </div>
@endauth

@endsection
