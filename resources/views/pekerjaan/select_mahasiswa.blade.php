@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Pilih Mahasiswa untuk Melihat Data Pekerjaan</h4>
                </div>
                <div class="card-body">
                    @if($mahasiswas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>NRP</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Kota</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mahasiswas as $mahasiswa)
                                    <tr>
                                        <td>{{ $mahasiswa->nrp }}</td>
                                        <td>{{ $mahasiswa->nama }}</td>
                                        <td>{{ $mahasiswa->email ?? '-' }}</td>
                                        <td>{{ $mahasiswa->kota ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.pekerjaan.show', $mahasiswa->nrp) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> Lihat Pekerjaan
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <h5>Tidak ada data mahasiswa</h5>
                            <p>Silakan tambahkan data mahasiswa terlebih dahulu.</p>
                            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-primary">
                                Kelola Mahasiswa
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection