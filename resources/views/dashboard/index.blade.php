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
                        Role: {{ Auth::user()->roles->name }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection