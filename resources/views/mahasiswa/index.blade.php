@extends('layouts.app')

@section('content')
    <h1>Daftar Mahasiswa</h1>

    <form method="GET" action="{{ route('admin.mahasiswa.index') }}" class="mb-4">
        <label>
            Cari Nama atau NRP:
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NRP...">
        </label>

        <label>
            Status Kelulusan:
            <select name="iscomplete" onchange="this.form.submit()">
                <option value="">-- Semua --</option>
                <option value="1" {{ request('iscomplete') == '1' ? 'selected' : '' }}>Sudah Lulus</option>
                <option value="0" {{ request('iscomplete') == '0' ? 'selected' : '' }}>Belum Lulus</option>
            </select>
        </label>

        <button type="submit">Filter</button>
        <a href="{{ route('admin.mahasiswa.index') }}">Reset</a>
    </form>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>NRP</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Provinsi</th>
                <th>Kota</th>
                <th>Status Kelulusan</th>
                <th>Pendidikan</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mahasiswa as $mhs)
                <tr>
                    <td>{{ $mhs->nrp }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->sex }}</td>
                    <td>{{ $mhs->propinsi->nama ?? '-' }}</td>
                    <td>{{ $mhs->kota }}</td>
                    <td>
                        @if ($mhs->iscomplete)
                            <span style="color:green; font-weight:bold;">Sudah Lulus</span>
                        @else
                            <span style="color:red;">Belum Lulus</span>
                        @endif
                    </td>
                    <td>
                        @if($mhs->pendidikan->count() > 0)
                            <ul style="list-style-type: none; padding-left: 0;">
                                @foreach($mhs->pendidikan as $pend)
                                    <li>
                                        <a href="{{ route('admin.pendidikan.index', ['nrp' => $mhs->nrp]) }}" style="margin-left:5px; padding: 2px 5px; background-color:#3490dc; color:white; text-decoration:none; border-radius: 3px;">
                                            Lihat
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if($mhs->pekerjaan->count() > 0)
                            <ul style="list-style-type: none; padding-left: 0;">
                                @foreach($mhs->pekerjaan as $pek)
                                    <li>
                                        <a href="{{ route('admin.pekerjaan.index', ['nrp' => $mhs->nrp]) }}" style="margin-left:5px; padding: 2px 5px; background-color:#38c172; color:white; text-decoration:none; border-radius: 3px;">
                                            Lihat
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">Data mahasiswa tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $mahasiswa->links() }}
    </div>
@endsection