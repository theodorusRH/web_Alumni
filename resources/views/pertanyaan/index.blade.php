@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Daftar Pertanyaan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Pesan</th>
                <th>Waktu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pertanyaans as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->pesan }}</td>
                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <form action="{{ route('pertanyaan.destroy', $item->idpertanyaan) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada pertanyaan</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $pertanyaans->links() }}
</div>
@endsection
