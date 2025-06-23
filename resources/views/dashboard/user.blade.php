@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Dashboard User</h3>

    <div class="row">
        {{-- Welcome Card --}}
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Selamat Datang, {{ Auth::user()->username }}!</h5>
                    <p class="card-text">Anda login sebagai <strong>{{ Auth::user()->roles->name }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Foto Profil dan Info Dasar --}}
        <div class="{{ Auth::user()->roles->name === 'alumni' ? 'col-md-4' : 'col-md-12' }}">
            <div class="card">
                <div class="card-body text-center">
                    @if (Auth::user()->foto)
                        <img src="{{ asset('images/foto_user/' . Auth::user()->foto) }}" 
                            class="img-thumbnail mb-2" 
                            style="width: 200px; height: 200px; object-fit: cover; object-position: center; cursor: pointer;"
                            data-bs-toggle="modal" data-bs-target="#fotoModal" id="fotoThumbnail">
                    @else
                        <div class="mb-2 border bg-light mx-auto" style="width:150px; height:150px; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-person-circle" style="font-size: 4rem; color: #ccc;"></i>
                        </div>
                    @endif
                    <!-- Modal untuk menampilkan foto besar -->
                    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img id="modalFoto" src="{{ asset('images/foto_user/' . Auth::user()->foto) }}" alt="Foto Besar" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="mt-2">
                        <p class="mb-1"><strong>ID:</strong> {{ Auth::user()->id }}</p>
                        <p class="mb-1"><strong>Username:</strong> {{ Auth::user()->username }}</p>
                        <p class="mb-1"><strong>Role:</strong> {{ Auth::user()->roles->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informasi User khusus alumni --}}
        @if (Auth::user()->roles->name === 'alumni')
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Informasi User</h5>
                    </div>
                    <div class="card-body">
                        @if (isset($mahasiswa))
                            {{-- Tampilkan data mahasiswa --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama:</strong> {{ $mahasiswa->nama ?? '-' }}</p>
                                    <p><strong>Email:</strong> {{ $mahasiswa->email ?? '-' }}</p>
                                    <p><strong>Telepon:</strong> {{ $mahasiswa->telepon ?? '-' }}</p>
                                    <p><strong>No HP:</strong> {{ $mahasiswa->hp ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Alamat:</strong> {{ $mahasiswa->alamat ?? '-' }}</p>
                                    <p><strong>Kota:</strong> {{ $mahasiswa->kota ?? '-' }}</p>
                                    <p><strong>Tempat Lahir:</strong> {{ $mahasiswa->tmptlahir ?? '-' }}</p>
                                    <p><strong>Tanggal Lahir:</strong> {{ $mahasiswa->tgllahir ? $mahasiswa->tgllahir->format('d-m-Y') : '-' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="text-center">
                                <p>Data lengkap belum tersedia. Silakan lengkapi profil Anda.</p>
                                <a href="{{ route('profile') }}" class="btn btn-primary">Lengkapi Profil</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if (Auth::user()->roles->name === 'alumni')
    <div class="row mt-4">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tugasAkhir-tab" data-bs-toggle="tab" href="#tugasAkhir" role="tab">Tugas Akhir</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pendidikan-tab" data-bs-toggle="tab" href="#pendidikan" role="tab">Riwayat Pendidikan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pekerjaan-tab" data-bs-toggle="tab" href="#pekerjaan" role="tab">Riwayat Pekerjaan</a>
                </li>
            </ul>

            <div class="tab-content mt-3" id="dashboardTabsContent">
                {{-- Tab Tugas Akhir --}}
                <div class="tab-pane fade show active" id="tugasAkhir" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h6>Data Tugas Akhir</h6>
                        </div>
                        <div class="card-body">
                            @if (isset($tugasAkhir))
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><strong>Judul:</strong> {{ $tugasAkhir->judul }}</p>
                                        <p><strong>Dosen Pembimbing 1:</strong> {{ $tugasAkhir->dosen1->nama ?? '-' }}</p>
                                        <p><strong>Dosen Pembimbing 2:</strong> {{ $tugasAkhir->dosen2->nama ?? '-' }}</p>
                                        <p><strong>Nilai:</strong> {{ $tugasAkhir->nilai_ta }}</p>
                                        <p><strong>Tanggal Lulus:</strong> {{ $tugasAkhir->tanggal_lulus_ta }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted">Data tugas akhir belum tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tab Riwayat Pendidikan --}}
                <div class="tab-pane fade" id="pendidikan" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h6>Riwayat Pendidikan</h6>
                        </div>
                        <div class="card-body">
                            @if (isset($pendidikans) && count($pendidikans) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Jurusan</th>
                                                <th>Semester</th>
                                                <th>Angkatan</th>
                                                <th>Tanggal Lulus</th>
                                                <th>IPK</th>
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
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Data riwayat pendidikan belum tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tab Riwayat Pekerjaan --}}
                <div class="tab-pane fade" id="pekerjaan" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h6>Riwayat Pekerjaan</h6>
                        </div>
                        <div class="card-body">
                            @if (isset($pekerjaans) && count($pekerjaans) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Jenis Pekerjaan</th>
                                                <th>Perusahaan</th>
                                                <th>Mulai Kerja</th>
                                                <th>Gaji Pertama</th>
                                                <th>Kota</th>
                                                <th>Jabatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pekerjaans as $p)
                                            <tr>
                                                <td>{{ $p->jenisPekerjaan->nama ?? '-' }}</td>
                                                <td>{{ $p->perusahaan }}</td>
                                                <td>{{ \Carbon\Carbon::parse($p->mulaikerja)->format('d-m-Y') }}</td>
                                                <td>Rp {{ number_format($p->gajipertama, 0, ',', '.') }}</td>
                                                <td>{{ $p->kota }}</td>
                                                <td>{{ $p->jabatan }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Data riwayat pekerjaan belum tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Visi dan Misi --}}
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Visi dan Misi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Visi</h6>
                            <p class="text-justify">
                                Menjadi sistem informasi alumni terdepan yang menghubungkan alumni dengan almamater, 
                                menciptakan jaringan profesional yang kuat, dan memberikan kontribusi positif bagi 
                                pengembangan institusi pendidikan dan masyarakat.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Misi</h6>
                            <ul>
                                <li>Menyediakan platform digital yang mudah digunakan untuk mengelola data alumni</li>
                                <li>Memfasilitasi komunikasi dan networking antar alumni</li>
                                <li>Mendukung pengembangan karir alumni melalui informasi lowongan kerja</li>
                                <li>Menyediakan data dan analisis untuk pengembangan program institusi</li>
                                <li>Membangun komunitas alumni yang solid dan berkelanjutan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row mt-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h6>Aksi Cepat</h6>
                </div> -->
                <div class="card-body">
                    <div class="row text-center">
                        {{-- Tombol Edit Profil: Tersedia untuk semua role --}}
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-block">
                                <i class="bi bi-person-gear"></i><br>
                                Edit Profil
                            </a>
                        </div>

                        {{-- Tombol khusus untuk admin --}}
                        @if(Auth::user()->roles->name === 'admin')
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-success btn-block">
                                    <i class="bi bi-people"></i><br>
                                    Data Mahasiswa
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.lowongan.index') }}" class="btn btn-outline-info btn-block">
                                    <i class="bi bi-briefcase"></i><br>
                                    Kelola Lowongan
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-warning btn-block">
                                    <i class="bi bi-calendar-event"></i><br>
                                    Kegiatan Alumni
                                </a>
                            </div>

                        {{-- Tombol khusus untuk alumni --}}
                        @elseif(Auth::user()->roles->name === 'alumni')
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-warning btn-block">
                                    <i class="bi bi-calendar-event"></i><br>
                                    Event Alumni
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('lowongan.index') }}" class="btn btn-outline-info btn-block">
                                    <i class="bi bi-briefcase"></i><br>
                                    Lowongan Kerja
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('lowongan.mine') }}" class="btn btn-outline-success btn-block">
                                    <i class="bi bi-send"></i><br>
                                    My Lowongan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection