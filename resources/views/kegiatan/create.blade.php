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
                <img id="fotoPreview" style="max-height: 150px; margin-top: 10px; display: none;" alt="Preview Foto">
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
