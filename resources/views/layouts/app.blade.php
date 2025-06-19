<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Web Alumni</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin-top: 0;
            padding-top: 0;
        }

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

        .nav-link {
            color: inherit;
            font-weight: normal;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #0d6efd;
            font-weight: 600;
        }

        .nav-link.text-primary,
        .nav-link.fw-bold {
            color: inherit !important;
            font-weight: normal !important;
        }

        .navbar-brand img {
            height: 60px;
            object-fit: contain;
        }

        .container.mt-4 {
            margin-top: 1rem !important; /* kurangi space */
        }
    </style>
</head>
<body>

@if(!Request::is('login') && !Request::is('register'))
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">

        {{-- Logo + Home Link --}}
        @auth
            @if(Auth::user()->isAdmin())
                <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard.index') }}">
                    <img src="{{ asset('images/kontak/LOGO_IKA_UBAYA.png') }}" alt="Logo UBAYA">
                </a>
            @elseif(Auth::user()->isUser())
                <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard.user') }}">
                    <img src="{{ asset('images/kontak/LOGO_IKA_UBAYA.png') }}" alt="Logo UBAYA">
                </a>
            @else
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/kontak/LOGO_IKA_UBAYA.png') }}" alt="Logo UBAYA">
                </a>
            @endif
        @else
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/kontak/LOGO_IKA_UBAYA.png') }}" alt="Logo UBAYA">
            </a>
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
                @auth
                    @if(Auth::user()->roles->name === 'admin')
                        <li class="nav-item mx-2 dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Data
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.mahasiswa.index') }}">Mahasiswa</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.pekerjaan.index') }}">Pekerjaan</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.pendidikan.index') }}">Pendidikan</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.lowongan.index') }}">Lowongan</a></li>
                            </ul>
                        </li>
                    @elseif(Auth::user()->roles->name === 'dosen')
                        <li class="nav-item mx-2 dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dosen
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dosen.tugasakhir') }}">Bimbingan TA</a></li>
                            </ul>
                        </li>
                    @elseif(Auth::user()->roles->name === 'alumni')
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('lowongan.mine') }}">My Lowongan</a>
                        </li>
                    @endif
                @endauth
                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ route('lowongan.index') }}">Lowongan</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ url('/kontak') }}">Kontak</a>
                </li>
                @auth
                    @if(Auth::user()->roles && Auth::user()->roles->name === 'admin')
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('admin.pertanyaan.index') }}">Pertanyaan</a>
                        </li>
                    @endif
                @endauth
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
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0 m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-link dropdown-item w-100 text-start">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
@endif

<div class="container mt-2">
    @yield('content')
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById('togglePassword');
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('toggleIcon');

        if (toggle && input && icon) {
            toggle.addEventListener('click', function () {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }
    });
</script> --}}
<script>
    document.querySelectorAll('.toggle-password').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
</script>
 @yield('js')
</body>
</html>
