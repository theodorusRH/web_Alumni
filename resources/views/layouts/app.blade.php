<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Web Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .navbar-nav {
            flex: 1;
            justify-content: center;
        }
        .auth-buttons {
            margin-left: auto;
        }

        .btn:hover {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.2s ease;
        }

        .btn-outline-primary:hover {
            background-color: white !important;
            border-color: #0d6efd !important;
            color: #0d6efd !important;
        }

        /* Navbar link default style */
        .nav-link {
            color: inherit; /* Warna default */
            font-weight: normal;
            transition: color 0.2s ease;
        }

        /* Navbar link saat hover */
        .nav-link:hover {
            color: #0d6efd; /* Warna biru saat hover */
            font-weight: 600; /* Bisa dibuat tebal saat hover */
        }

        /* Hilangkan style khusus untuk link aktif jika ada */
        .nav-link.text-primary,
        .nav-link.fw-bold {
            color: inherit !important;
            font-weight: normal !important;
        }
    </style>
</head>
<body>

@if(!Request::is('login') && !Request::is('register'))
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">

        {{-- Web Alumni button --}}
        @auth
            @if(Auth::user()->isAdmin())
                <a class="navbar-brand" href="{{ route('dashboard.index') }}">Web Alumni</a>
            @elseif(Auth::user()->isUser())
                <a class="navbar-brand" href="{{ route('dashboard.user') }}">Web Alumni</a>
            @else
                <a class="navbar-brand" href="{{ url('/') }}">Web Alumni</a>
            @endif
        @else
            <a class="navbar-brand" href="{{ url('/') }}">Web Alumni</a>
        @endauth

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav text-center">
                <li class="nav-item mx-2">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a class="nav-link" href="{{ route('dashboard.index') }}">Home</a>
                        @elseif(Auth::user()->isUser())
                            <a class="nav-link" href="{{ route('dashboard.user') }}">Home</a>
                        @else
                            <a class="nav-link" href="{{ url('/') }}">Home</a>
                        @endif
                    @else
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    @endauth
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ route('alumninews.index') }}">Berita</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ route('kegiatan.index') }}">Kegiatan Alumni</a>
                </li>
                <li class="nav-item mx-2 dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Data
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.mahasiswa.index') }}">Mahasiswa</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.pekerjaan.index') }}">Pekerjaan</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.pendidikan.index') }}">Pendidikan</a></li>
                        <li>
                            <a class="dropdown-item" href="
                                @auth
                                    @if(Auth::user()->isAdmin())
                                        {{ route('admin.lowongan.index') }}
                                    @else
                                        {{ route('lowongan.index') }}
                                    @endif
                                @else
                                    {{ route('lowongan.index') }}
                                @endauth
                            ">
                                Lowongan
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ url('/kontak') }}">Kontak</a>
                </li>
            </ul>

            <ul class="navbar-nav auth-buttons">
                @guest
                    <li class="nav-item mx-2">
                        <a class="btn px-3 {{ Request::is('login') ? 'btn-success' : 'btn-primary' }}" href="{{ route('login') }}" role="button">Sign In</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="btn px-3 {{ Request::is('register') ? 'btn-success btn-outline-success' : 'btn-outline-primary' }}" href="{{ route('register.form') }}" role="button">Sign Up</a>
                    </li>
                @else
                    <li class="nav-item mx-2">
                        <span class="nav-link">Welcome, {{ Auth::user()->username }}</span>
                    </li>
                    <li class="nav-item mx-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link p-0">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
@endif

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
