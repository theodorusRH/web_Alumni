@extends('layouts.app')

@section('content')
<h2>Kontak Kami</h2>
<p>Jika Anda memiliki pertanyaan, silakan isi form di bawah ini:</p>

<form action="{{ route('kontak.kirim') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="pesan" class="form-label">Pesan</label>
        <textarea class="form-control" id="pesan" name="pesan" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Kirim</button>
</form>
@endsection
