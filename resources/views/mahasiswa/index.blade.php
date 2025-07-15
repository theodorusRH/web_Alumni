@extends('layouts.app')

@section('content')
    @php
        $mahasiswaIndexRoute = Auth::user()->roles->name === 'admin'
            ? route('admin.mahasiswa.index')
            : route('dosen.mahasiswa.index');
    @endphp

    <h1>
        @if(Auth::user()->roles->name === 'admin')
            Daftar Mahasiswa
        @else
            Daftar Mahasiswa
        @endif
    </h1>

    <form method="GET" action="{{ $mahasiswaIndexRoute }}" class="mb-4">
        <label>
            Cari Nama atau NRP:
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NRP...">
        </label>

        <label style="margin-left: 20px;">
            Cari Angkatan:
            <input type="text" name="angkatan" value="{{ request('angkatan') }}" placeholder="Contoh: 2021">
        </label>

        <label style="margin-left: 20px;">
            Status Aktif:
            <select name="iscomplete">
                <option value="">-- Semua --</option>
                <option value="1" {{ request('iscomplete') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('iscomplete') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </label>

        <button type="submit" style="margin-left: 10px;">Filter</button>
        <a href="{{ $mahasiswaIndexRoute }}" style="margin-left: 10px;">Reset</a>
    </form>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>NRP</th>
                <th>Angkatan</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Provinsi</th>
                <th>Kota</th>
                <th>Status</th>
                @if(Auth::user()->roles->name === 'admin')
                    <th>Action</th>
                @endif
                <th>Pendidikan</th>
                <th>Pekerjaan</th>
                <th>Detail</th>
                @if(Auth::user()->roles->name === 'admin')
                    <th>Reset Password</th>
                @endif
                @if(Auth::user()->roles->name === 'admin')
                    <th>Update Password</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($mahasiswa as $mhs)
                <tr>
                    <td>{{ $mhs->nrp }}</td>
                    <td>{{ $mhs->angkatan }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->sex }}</td>
                    <td>{{ $mhs->propinsi->nama ?? '-' }}</td>
                    <td>{{ $mhs->kota }}</td>
                    <td>
                        @if ($mhs->iscomplete)
                            <span style="color:green; font-weight:bold;">Aktif</span>
                        @else
                            <span style="color:red;">Tidak Aktif</span>
                        @endif
                    </td>

                    @if(Auth::user()->roles->name === 'admin')
                        <td>
                            <form action="{{ route('admin.mahasiswa.toggleStatus', $mhs->nrp) }}" method="POST" onsubmit="return confirm('Ubah status Aktif alumni ini?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    style="padding: 4px 8px; border: none; border-radius: 3px; cursor: pointer;
                                        background-color: {{ $mhs->iscomplete ? '#dc3545' : '#28a745' }};
                                        color: white;">
                                    {{ $mhs->iscomplete ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </td>
                    @endif

                    <td>
                        @if($mhs->pendidikan->count() > 0)
                            <a href="{{ route('pendidikan.show', ['nrp' => $mhs->nrp]) }}" 
                               style="margin-left:5px; padding: 2px 5px; background-color:#3490dc; color:white; text-decoration:none; border-radius: 3px;">
                                Lihat
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($mhs->pekerjaan->count() > 0)
                            <a href="{{ route('pekerjaan.show', ['nrp' => $mhs->nrp]) }}" 
                               style="margin-left:5px; padding: 2px 5px; background-color:#38c172; color:white; text-decoration:none; border-radius: 3px;">
                                Lihat
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('mahasiswa.showDetail', $mhs->nrp) }}" 
                           style="padding: 4px 8px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 3px;">
                            Lihat Detail
                        </a>
                    </td>

                    @if(Auth::user()->roles->name === 'admin')
                        <td>
                            <form action="{{ route('admin.mahasiswa.resetPassword', $mhs->nrp) }}" method="POST" onsubmit="return confirm('Reset password mahasiswa ini ke default?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    style="padding: 4px 8px; border: none; border-radius: 3px; cursor: pointer;
                                        background-color: #ffc107; color: black;">
                                    Reset
                                </button>
                            </form>
                        </td>
                    @endif
                    @if(Auth::user()->roles->name === 'admin')
                        <td>
                            <form action="{{ route('admin.mahasiswa.updatePassword', $mhs->nrp) }}" method="POST" style="display: flex; gap: 5px;">
                                @csrf
                                @method('PATCH')
                                <input type="password" name="new_password" placeholder="Password baru" required style="width: 120px;">
                                <button type="submit"
                                    style="padding: 2px 6px; background-color: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer;">
                                    Simpan
                                </button>
                            </form>
                        </td>
                    @endif

                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align:center;">Data mahasiswa tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $mahasiswa->links() }}
    </div>
@endsection