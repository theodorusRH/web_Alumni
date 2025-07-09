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

                {{-- Tampilan foto lama --}}
                @if ($user->foto)
                    <img id="fotoPreviewLama" 
                        src="{{ asset('images/foto_user/' . $user->foto) }}" 
                        class="img-thumbnail mb-2 mx-auto d-block" 
                        style="width: 200px; height: 200px; object-fit: cover; object-position: center; cursor: pointer;"
                        alt="Foto Lama"
                        data-bs-toggle="modal" data-bs-target="#fotoModal">
                    <small class="text-muted d-block text-center">Foto Lama</small>
                @else
                    <img id="fotoPreviewLama" 
                        class="img-thumbnail mb-2 mx-auto d-block" 
                        style="width: 200px; height: 200px; object-fit: cover; object-position: center;"
                        alt="Foto Lama">
                    <small class="text-muted d-block text-center">Belum ada foto</small>
                @endif

                {{-- Preview foto baru --}}
                <div id="fotoBaruContainer" class="mt-3 text-center" style="display: none;">
                    <img id="fotoPreviewBaru" class="img-thumbnail" 
                        style="width: 200px; height: 200px; object-fit: cover; object-position: center; cursor: pointer;" 
                        alt="Foto Baru"
                        data-bs-toggle="modal" data-bs-target="#fotoBaruModal">
                    <small class="text-muted d-block">Preview Foto Baru</small>
                </div>

                <div class="modal fade" id="fotoBaruModal" tabindex="-1" aria-labelledby="fotoBaruModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img id="modalFotoBaru" src="#" alt="Preview Besar Foto Baru" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Input file --}}
                <input type="file" name="foto" class="form-control mt-2" id="fotoInput">

                {{-- Modal besar untuk zoom foto --}}
                @if ($user->foto)
                <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img id="modalFoto" src="{{ asset('images/foto_user/' . $user->foto) }}" alt="Foto Besar" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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

                {{-- Password Lama --}}
                <div class="mb-3">
                    <label>Password Lama</label>
                    <div class="input-group">
                        <input type="password" name="password_lama" id="passwordLama" class="form-control">
                        <span class="input-group-text toggle-password" data-target="passwordLama" style="cursor:pointer;">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback" id="errorPasswordLama"></div>
                </div>

                {{-- Password Baru --}}
                <div class="mb-3">
                    <label>Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="password_baru" id="passwordBaru" class="form-control">
                        <span class="input-group-text toggle-password" data-target="passwordBaru" style="cursor:pointer;">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback" id="errorPasswordBaru"></div>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-3">
                    <label>Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="password_konfirmasi" id="passwordKonfirmasi" class="form-control">
                        <span class="input-group-text toggle-password" data-target="passwordKonfirmasi" style="cursor:pointer;">
                            <i class="bi bi-eye-slash"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback" id="errorPasswordKonfirmasi"></div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const input = document.getElementById('fotoInput');
                const previewBaru = document.getElementById('fotoPreviewBaru');
                const containerBaru = document.getElementById('fotoBaruContainer');
                const modalImg = document.getElementById('modalFoto');
                const thumbnail = document.getElementById('fotoPreviewLama');

                // Klik gambar lama untuk lihat modal
                if (thumbnail && modalImg && thumbnail.src) {
                    thumbnail.addEventListener('click', function () {
                        if (this.src) {
                            modalImg.src = this.src;
                        }
                    });
                }

                // Preview gambar baru
                input.addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewBaru.src = e.target.result;
                            modalFotoBaru.src = e.target.result;
                            containerBaru.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>

        @if ($user->roles->name === 'alumni')
        <hr>
        <ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="dataMahasiswa-tab" data-bs-toggle="tab" href="#dataMahasiswa" role="tab">Data Mahasiswa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tugasAkhir-tab" data-bs-toggle="tab" href="#tugasAkhir" role="tab">Tugas Akhir</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pendidikan-tab" data-bs-toggle="tab" href="#pendidikan" role="tab">Pendidikan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pekerjaan-tab" data-bs-toggle="tab" href="#pekerjaan" role="tab">Pekerjaan</a>
            </li>
        </ul>

        <div class="tab-content" id="profileTabsContent">
            {{-- @if ($mahasiswa && $user->roles->name === 'alumni') --}}

            <div class="tab-pane fade show active" id="dataMahasiswa" role="tabpanel">
                <h5 class="mt-3">Data Mahasiswa</h5>
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
                            <option value="{{ $prov->idpropinsi }}" {{ $mahasiswa->idpropinsi == $prov->idpropinsi ? 'selected' : '' }}>
                                {{ $prov->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- @endif --}}

            {{-- @if ($tugasAkhir && $user->roles->name === 'alumni') --}}
            <div class="tab-pane fade show active" id="tugasAkhir" role="tabpanel">
                <h5 class="mt-3">Data Tugas Akhir</h5>

                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ $tugasAkhir->judul ?? '' }}">
                </div>

                <div class="mb-3">
                    <label>Dosen Pembimbing 1</label>
                    <select name="kode_dosen1" class="form-control">
                        @if (isset($tugasAkhir) && $tugasAkhir->dosen1)
                            <option selected hidden value="{{ $tugasAkhir->kode_dosen1 }}">{{ $tugasAkhir->dosen1->nama }}</option>
                        @else
                            <option value="" selected hidden>-- Pilih Dosen --</option>
                        @endif

                        @foreach ($dosenList as $dosen)
                            <option value="{{ $dosen->nip }}">
                                {{ $dosen->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Dosen Pembimbing 2</label>
                    <select name="kode_dosen2" class="form-control">
                        @if (isset($tugasAkhir) && $tugasAkhir->dosen2)
                            <option selected hidden value="{{ $tugasAkhir->kode_dosen2 }}">{{ $tugasAkhir->dosen2->nama }}</option>
                        @else
                            <option value="" selected hidden>-- Pilih Dosen --</option>
                        @endif

                        @foreach ($dosenList as $dosen)
                            <option value="{{ $dosen->nip }}">
                                {{ $dosen->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tanggal Lulus</label>
                    <input type="date" name="tanggal_lulus_ta" class="form-control" value="{{ $tugasAkhir->tanggal_lulus_ta ?? '' }}">
                </div>
            </div>

            <div class="tab-pane fade" id="pendidikan" role="tabpanel">
                <a href="#" class="btn btn-info mb-2" data-bs-toggle="modal" data-bs-target="#modalCreatePendidikan">Tambah</a>

                <h5 class="mt-3">Riwayat Pendidikan</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jurusan</th>
                            <th>Jumlah Semester</th>
                            <th>Angkatan</th>
                            <th>Tanggal Lulus</th>
                            <th>IPK</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendidikans as $p)
                        <tr>
                            <td>{{ $p->jurusan->nama }}</td>
                            <td>{{ $p->jmlsemester }}</td>
                            <td>{{ $p->angkatan }}</td>
                            <td>{{ $p->tanggallulus }}</td>
                            <td>{{ $p->ipk }}</td>
                            <td>
                                <a href="#modalPendidikanEdit" class="btn btn-info" data-toggle="modal"
                                onclick="getPendidikanEditForm('{{ $p->id }}')">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="pekerjaan" role="tabpanel">
                <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreatePekerjaan">Tambah</a>

                <h5 class="mt-3">Riwayat Pekerjaan</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Pekerjaan</th>
                            <th>Perusahaan</th>
                            <th>Telepon</th>
                            <th>Mulai Kerja</th>
                            <th>Gaji Pertama</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Kode Pos</th>
                            <th>Provinsi</th>
                            <th>Bidang Usaha</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pekerjaans as $p)
                        <tr>
                            <td>{{ $p->jenisPekerjaan->nama ?? '-' }}</td>
                            <td>{{ $p->perusahaan }}</td>
                            <td>{{ $p->telepon }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->mulaikerja)->format('Y-m-d') }}</td>
                            <td>{{ number_format($p->gajipertama, 0, ',', '.') }}</td>
                            <td>{{ $p->alamat }}</td>
                            <td>{{ $p->kota }}</td>
                            <td>{{ $p->kodepos }}</td>
                            <td>{{ $p->propinsi->nama ?? '-' }}</td>
                            <td>{{ $p->bidangusaha }}</td>
                            <td>{{ $p->jabatan }}</td>
                            <td>
                                <a href="#modalPekerjaanEdit" class="btn btn-info" data-toggle="modal"
                                onclick="getPekerjaanEditForm('{{ $p->id }}')">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        <button type="submit" class="btn btn-primary" id="submitBtn">Update Profil</button>
    </form>
</div>

@if ($user->roles->name === 'alumni')
<div class="modal fade" id="modalPekerjaanEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="modalPekerjaanContent">
                <!-- Form akan dimuat via AJAX -->
            </div>
        </div>
    </div>
</div>
@endif

@if ($user->roles->name === 'alumni')
<div class="modal fade" id="modalPendidikanEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="modalPendidikanContent">
                <!-- Form akan dimuat via AJAX -->
            </div>
        </div>
    </div>
</div>
@endif

@if ($user->roles->name === 'alumni')
<div class="modal fade" id="modalCreatePendidikan" tabindex="-1" role="dialog" aria-labelledby="modalCreatePendidikanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('profile.storePendidikan') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Riwayat Pendidikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Jurusan</label>
                        <select name="idjurusan" class="form-control" required>
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach ($jurusanList as $jur)
                                <option value="{{ $jur->idjurusan }}">{{ $jur->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Jumlah Semester</label>
                        <input type="number" name="jmlsemester" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label>Angkatan</label>
                        <input type="text" name="angkatan" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Lulus</label>
                        <input type="date" name="tanggallulus" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>IPK</label>
                        <input type="text" name="ipk" class="form-control" placeholder="Contoh: 3.75">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


@if ($user->roles->name === 'alumni')
<div class="modal fade" id="modalCreatePekerjaan" tabindex="-1" role="dialog" aria-labelledby="modalCreatePekerjaanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('profile.storePekerjaan') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Riwayat Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Jenis Pekerjaan</label>
                        <select name="idjenispekerjaan" class="form-control">
                            <option value="">-- Pilih Jenis Pekerjaan --</option>
                            @foreach ($jenisPekerjaanList as $jp)
                                <option value="{{ $jp->idjenispekerjaan }}">{{ $jp->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Perusahaan</label>
                        <input type="text" name="perusahaan" class="form-control" placeholder="Nama perusahaan">
                    </div>

                    <div class="mb-3">
                        <label>Telepon</label>
                        <input type="text" name="telepon" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Mulai Kerja</label>
                        <input type="date" name="mulaikerja" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Gaji Pertama</label>
                        <input type="number" name="gajipertama" class="form-control" step="1000">
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Kota</label>
                        <input type="text" name="kota" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Kode Pos</label>
                        <input type="text" name="kodepos" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Provinsi</label>
                        <select name="idpropinsi" class="form-control">
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach ($propinsiList as $prov)
                                <option value="{{ $prov->idpropinsi }}">{{ $prov->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Bidang Usaha</label>
                        <input type="text" name="bidangusaha" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@section('js')
<script>
        document.addEventListener("DOMContentLoaded", function () {
        function setError(inputId, message) {
            const input = document.getElementById(inputId);
            const errorDiv = document.getElementById('error' + inputId.charAt(0).toUpperCase() + inputId.slice(1));
            input.classList.add('is-invalid');
            errorDiv.textContent = message;
        }

        function clearError(inputId) {
            const input = document.getElementById(inputId);
            const errorDiv = document.getElementById('error' + inputId.charAt(0).toUpperCase() + inputId.slice(1));
            input.classList.remove('is-invalid');
            errorDiv.textContent = '';
        }

        function validatePasswordFields() {
            const lama = document.getElementById('passwordLama').value;
            const baru = document.getElementById('passwordBaru').value;
            const konfirmasi = document.getElementById('passwordKonfirmasi').value;

            let valid = true;

            clearError('passwordLama');
            clearError('passwordBaru');
            clearError('passwordKonfirmasi');

            if (lama && baru && lama === baru) {
                setError('passwordBaru', 'Password baru tidak boleh sama dengan password lama.');
                valid = false;
            }

            if (baru && konfirmasi && baru !== konfirmasi) {
                setError('passwordKonfirmasi', 'Konfirmasi tidak cocok dengan password baru.');
                valid = false;
            }

            // Enable/disable tombol submit
            document.getElementById('submitBtn').disabled = !valid;

            return valid;
        }

        // Pasang listener input langsung
        ['passwordLama', 'passwordBaru', 'passwordKonfirmasi'].forEach(id => {
            document.getElementById(id).addEventListener('input', validatePasswordFields);
        });

        // Submit final tetap dicek
        document.querySelector('form').addEventListener('submit', function (e) {
            if (!validatePasswordFields()) {
                e.preventDefault();
            }
        });
    });

    function getPekerjaanEditForm(pekerjaan_id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("profile.getPekerjaanEditForm") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': pekerjaan_id
            },
            success: function(data) {
                $('#modalPekerjaanContent').html(data.msg);
                $('#modalPekerjaanEdit').modal('show');
            }
        });
    }

    function getPendidikanEditForm(pendidikan_id) {
        $.ajax({
            type: 'POST',
            url: '{{ route("profile.getPendidikanEditForm") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': pendidikan_id
            },
            success: function(data) {
                $('#modalPendidikanContent').html(data.msg);
                $('#modalPendidikanEdit').modal('show');
            }
        });
    }

</script>
@endsection