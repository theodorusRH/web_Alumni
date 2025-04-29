@extends('layouts.conquer2')

@section('content')
<div class="container-fluid">
    @csrf
    {{ session('check_login') }}
    @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
    @endif

</div>
@endsection
