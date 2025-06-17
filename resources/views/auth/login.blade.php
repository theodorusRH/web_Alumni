@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <h3 class="mb-4 text-center">Sign In</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input id="id" type="text" name="id" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>

        <p class="mt-3 text-center">
            Don't have an account? <a href="{{ route('register.form') }}">Sign Up</a>
        </p>
    </div>
</div>
@endsection
