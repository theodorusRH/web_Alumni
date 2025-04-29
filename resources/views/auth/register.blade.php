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
        <label>Name</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">

        <br>

        <label>Phone Number</label>
        <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">

        <br>

        <label>Email</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">

        <br>

        <label>Address</label>
        <textarea name="address" class="form-control">{{ old('address') }}</textarea>

        <br>

        <label>Gender</label>
        <select name="gender" class="form-control" required>
            <option value="">-- Select --</option>
            {{-- <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option> --}}
            {{-- {{ dd($genders) }} --}}
            @foreach($gender as $g)
                <option value="{{$g}}">{{$g}}</option>
            @endforeach
        </select>

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

        <label>Role</label>
        <select name="roles_id" class="form-control" required>
            <option value="">-- Select --</option>
            @foreach ($role as $r)
                <option value="{{ $r->id }}" {{ old('roles_id') == $r->id ? 'selected' : '' }}>
                    {{-- {{ ucfirst($role->name) }} --}} 
                    {{-- ucfirst ini guna nya agar besar kecil huruf mirip seperti pada database --}}
                    {{ $r->name }}
                </option>
            @endforeach
        </select>

        <br>

        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
</div>
@endsection
