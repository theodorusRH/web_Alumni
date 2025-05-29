@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Welcome to Dashboard</h1>
            <p>Welcome, {{ Auth::user()->username }}! You are logged in as {{ Auth::user()->roles->name }}.</p>
            
            <div class="card">
                <div class="card-header">
                    Dashboard Overview
                </div>
                <div class="card-body">
                    <h5 class="card-title">User Info</h5>
                    <p class="card-text">
                        Name: {{ Auth::user()->username }}<br>
                        Email: {{ Auth::user()->email }}<br>
                        Phone: {{ Auth::user()->phone }}<br>
                        Role: {{ Auth::user()->roles->name }}
                    </p>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    Data Karyawan
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Posisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employee as $emp)
                            <tr>
                                <td>{{ $emp->name }}</td>
                                <td>{{ $emp->email }}</td>
                                <td>{{ $emp->position }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection