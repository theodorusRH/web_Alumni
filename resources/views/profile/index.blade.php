@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Profil</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- <div class="mb-3">
            <label>Foto Profil</label><br>
            @if ($user->foto)
                <img src="{{ asset('images/foto_user/' . $user->foto) }}" width="120" class="mb-2">
            @endif
            <input type="file" name="foto" class="form-control">
        </div>


        <div class="mb-3">
            <label>ID</label>
            <input type="text" name="id" class="form-control" value="{{ $user->id }}" {{ $user->roles->name === 'mahasiswa' ? 'readonly' : '' }}>
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}">
        </div>

        <div class="mb-3">
            <label>Password (kosongkan jika tidak ingin ganti)</label>
            <div class="input-group">
                <input type="password" name="password" id="passwordInput" class="form-control">
                <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                </span>
            </div>
        </div> --}}

        <div class="row">
            {{-- Foto dan upload --}}
            <div class="col-md-4 text-center">
                <label class="form-label fw-bold">Foto</label><br>
                @if ($user->foto)
                    <img src="{{ asset('images/foto_user/' . $user->foto) }}" class="img-thumbnail mb-2" width="200">
                @else
                    <div class="mb-2 border bg-light" style="width:200px; height:200px; display:inline-block;"></div>
                @endif
                <input type="file" name="foto" class="form-control mt-2">
            </div>

            {{-- Input ID, Username, Password --}}
            <div class="col-md-8">
                <div class="mb-3">
                    <label>ID</label>
                    <input type="text" name="id" class="form-control"
                        value="{{ $user->id }}" {{ $user->roles->name === 'alumni' ? 'readonly' : '' }}>
                </div>

                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $user->username }}">
                </div>

                <div class="mb-3">
                    <label>Password (kosongkan jika tidak ingin ganti)</label>
                    <div class="input-group">
                        <input type="password" name="password" id="passwordInput" class="form-control">
                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if ($mahasiswa)
            <hr>
            <h5>Data Mahasiswa</h5>

            <div class="mb-3"><label>Nama</label><input type="text" name="nama" class="form-control" value="{{ $mahasiswa->nama }}"></div>
            <div class="mb-3"><label>Alamat</label><input type="text" name="alamat" class="form-control" value="{{ $mahasiswa->alamat }}"></div>
            <div class="mb-3"><label>Kota</label><input type="text" name="kota" class="form-control" value="{{ $mahasiswa->kota }}"></div>
            <div class="mb-3"><label>Kode Pos</label><input type="text" name="kodepos" class="form-control" value="{{ $mahasiswa->kodepos }}"></div>
            <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="{{ $mahasiswa->email }}"></div>
            <div class="mb-3"><label>Telepon</label><input type="text" name="telepon" class="form-control" value="{{ $mahasiswa->telepon }}"></div>
            <div class="mb-3"><label>No HP</label><input type="text" name="hp" class="form-control" value="{{ $mahasiswa->hp }}"></div>
            <div class="mb-3"><label>Tempat Lahir</label><input type="text" name="tmptlahir" class="form-control" value="{{ $mahasiswa->tmptlahir }}"></div>
            <div class="mb-3"><label>Tanggal Lahir</label><input type="date" name="tgllahir" class="form-control" value="{{ $mahasiswa->tgllahir?->format('Y-m-d') }}"></div>
            <div class="mb-3"><label>Alamat Luar Kota</label><input type="text" name="alamatluarkota" class="form-control" value="{{ $mahasiswa->alamatluarkota }}"></div>
            <div class="mb-3"><label>Kota Luar Kota</label><input type="text" name="kotaluarkota" class="form-control" value="{{ $mahasiswa->kotaluarkota }}"></div>
            <div class="mb-3"><label>Kodepos Luar Kota</label><input type="text" name="kodeposluarkota" class="form-control" value="{{ $mahasiswa->kodeposluarkota }}"></div>
            <div class="mb-3"><label>Telepon Luar Kota</label><input type="text" name="teleponluarkota" class="form-control" value="{{ $mahasiswa->teleponluarkota }}"></div>
            <div class="mb-3">
                <label>Provinsi</label>
                <select name="idpropinsi" class="form-control">
                    <option value="">-- Pilih Provinsi --</option>
                    @foreach ($propinsiList as $prov)
                        <option value="{{ $prov->idpropinsi }}"
                            {{ $mahasiswa->idpropinsi == $prov->idpropinsi ? 'selected' : '' }}>
                            {{ $prov->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        {{-- <pre>
        {{ var_dump($tugasAkhir) }}
        </pre> --}}
        @if ($tugasAkhir)
        <hr>
        <h5>Data Tugas Akhir</h5>

        <div class="mb-3"><label>Judul</label>
            <input type="text" class="form-control" value="{{ $tugasAkhir->judul }}" readonly>
        </div>

        <div class="mb-3"><label>Dosen Pembimbing 1</label>
            <input type="text" class="form-control" 
                value="{{ $tugasAkhir->dosen1->nama ?? '-' }}" readonly>
        </div>

        <div class="mb-3"><label>Dosen Pembimbing 2</label>
            <input type="text" class="form-control" 
                value="{{ $tugasAkhir->dosen2->nama ?? '-' }}" readonly>
        </div>

        <div class="mb-3"><label>Nilai</label>
            <input type="text" class="form-control" value="{{ $tugasAkhir->nilai_ta }}" readonly>
        </div>

        <div class="mb-3"><label>Tanggal Lulus</label>
            <input type="text" class="form-control" value="{{ $tugasAkhir->tanggal_lulus_ta }}" readonly>
        </div>
    @endif


        <button type="submit" class="btn btn-primary">Update Profil</button>
    </form>
</div>
@endsection