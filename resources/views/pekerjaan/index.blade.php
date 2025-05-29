@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pekerjaan - {{ $mahasiswa->nama }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($pekerjaans->isEmpty())
        <p>Tidak ada data pekerjaan.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jenis Pekerjaan</th>
                    <th>Bidang Usaha</th>
                    <th>Perusahaan</th>
                    <th>Mulai Kerja</th>
                    <th>Gaji Pertama</th>
                    <th>Kota</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pekerjaans as $pekerjaan)
                <tr>
                    <td>{{ $pekerjaan->jenisPekerjaan->nama ?? '-' }}</td>
                    <td>{{ $pekerjaan->bidangusaha ?? '-' }}</td>
                    <td>{{ $pekerjaan->perusahaan ?? '-' }}</td>
                    <td>
                        {{ 
                            $pekerjaan->mulaikerja 
                            ? \Carbon\Carbon::parse($pekerjaan->mulaikerja)->format('d-m-Y') 
                            : '-' 
                        }}
                    </td>
                    <td>{{ $pekerjaan->gajipertama ?? '-' }}</td>
                    <td>{{ $pekerjaan->kota ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('admin.mahasiswa.index', $mahasiswa->nrp) }}" class="btn btn-secondary mt-3">Kembali ke Mahasiswa</a>
</div>
@endsection
