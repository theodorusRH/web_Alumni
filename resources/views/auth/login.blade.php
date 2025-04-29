@extends('layouts.auth')

@section('content')
<div class="login-box text-center">
    @if ($errors->any())
        <div class="alert alert-danger text-start">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <h4 class="mb-4">Login</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="username">Username</label>
        <input id="username" type="text" name="username" class="form-control" required>

        <br>

        <label for="password">Password</label>
        <input id="password" type="password" name="password" class="form-control" required>

        <br>

        <button type="submit" class="btn btn-success btn-block w-100">Login</button>

        <br>
        
        <a href="{{ route('register') }}" class="btn btn-link">Don't have an account? Sign up</a>
    </form>
</div>
@endsection
