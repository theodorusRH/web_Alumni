@extends('layouts.auth')

@section('content')
<div class="login-box text-start">
    <h4 class="text-center mb-3">Register</h4>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif
        {{-- ada {{old('name')}} itu buat nge save data yang sudah di isi, agar data nya tidak hilang jika ke refresh --}}
        <label>NRP</label>
        <input type="text" name="nrp" class="form-control" required value="{{ old('nrp') }}">
        
        <br>
        
        <label>Name</label>
        <input type="text" name="nama" class="form-control" required value="{{ old('nama') }}">

        <br>

        <label>Email</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">

        {{-- ini buat spasi antar label pake garis --}}
        <hr>

        <label>Username</label>
        <input type="text" name="username" class="form-control" required value="{{ old('username') }}">

        <br>

        <label>Password</label>
        <input type="password" name="password" class="form-control" required>

        <br>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>

        <br>

        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
</div>
@endsection
