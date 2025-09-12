<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: #333 !important;
            display: flex;
            align-items: center;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: #00a693;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: white;
        }

        .dropdown-menu-custom {
            background: #5a6c7d;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
            padding: 8px 0;
            overflow: hidden;
            margin-top: 8px;
        }

        .dropdown-item-custom {
            color: white;
            padding: 12px 20px;
            font-size: 14px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            transition: background-color 0.3s;
        }

        .dropdown-item-custom:hover {
            background-color: rgba(255,255,255,.15);
            color: white;
        }

        .dropdown-item-custom:last-child {
            border-bottom: none;
        }

        .dropdown-toggle-custom {
            background: #5a6c7d;
            border: none;
            border-radius: 8px;
            color: white;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s;
            font-size: 14px;
            margin: 0 4px;
        }

        .dropdown-toggle-custom:hover {
            background: #4a5c6d;
            color: white;
            transform: translateY(-1px);
        }

        .dropdown-toggle-custom::after {
            margin-left: 8px;
        }

        .nav-item-spacing {
            margin: 0 2px;
        }

        .btn-login {
            background: #5a6c7d;
            border: none;
            border-radius: 8px;
            color: white;
            padding: 8px 16px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .btn-login:hover {
            background: #4a5c6d;
            color: white;
            transform: translateY(-1px);
        }

        /* Menu grouping style */
        .menu-group {
            display: flex;
            background: #5a6c7d;
            border-radius: 12px;
            padding: 4px;
            margin: 0 8px;
        }

        .menu-group .dropdown-toggle-custom {
            margin: 0 2px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="logo-icon">
                        <i class="fas fa-chart-line text-primary"></i>
                    </div>
                    <span>Daspimkum bedas</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Center Menu -->
                    <ul class="navbar-nav me-auto">
                        @auth
                        @if(Auth::user()->role->name === 'admin')
                            <!-- Menu Dropdown -->
                            <li class="nav-item dropdown nav-item-spacing">
                                <button class="btn dropdown-toggle dropdown-toggle-custom" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-bars me-1"></i> MENU
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                    <li><a class="dropdown-item dropdown-item-custom" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                    <li><a class="dropdown-item dropdown-item-custom" href="{{ route('admin.agenda.index') }}"><i class="fas fa-calendar-alt me-2"></i>Agenda Kegiatan</a></li>
                                    
                                    <li><a class="dropdown-item dropdown-item-custom" href="{{ route('admin.iku.index') }}"><i class="fas fa-calendar-alt me-2"></i>Iku</a></li>
                                    <li><a class="dropdown-item dropdown-item-custom" href="{{ route('admin.anggaran.index') }}"><i class="fas fa-calendar-alt me-2"></i>Realisasi Anggaran</a></li>
                                    <li><a class="dropdown-item dropdown-item-custom" href="{{ route('admin.danabergulir.index') }}"><i class="fas fa-calendar-alt me-2"></i>Dana Bergulir</a></li>
                                    {{-- <li><a class="dropdown-item dropdown-item-custom" href="{{ route('users.index') }}"><i class="fas fa-users me-2"></i>Data Users</a></li> --}}
                                </ul>
                            </li>

                            <!-- Data Dropdown -->
                            <li class="nav-item dropdown nav-item-spacing">
                                <button class="btn dropdown-toggle dropdown-toggle-custom" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-database me-1"></i> DATA
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom">
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('admin.koperasi.index') }}"><i class="fas fa-calendar-alt me-2"></i>Data Koperasi</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('admin.umkm.index') }}"><i class="fas fa-calendar-alt me-2"></i>Data UMKM</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('admin.dokdiskop.index') }}"><i class="fas fa-calendar-alt me-2"></i>Dokumen Diskop Ukm</a></li>
                                <li><a class="dropdown-item dropdown-item-custom" href="{{ route('admin.pegawai.index') }}"><i class="fas fa-calendar-alt me-2"></i>Data Pegawai</a></li>
                                </ul>
                            </li>

                            <!-- Tentang -->
                            <li class="nav-item nav-item-spacing">
                                <button class="btn dropdown-toggle-custom" type="button">
                                    <i class="fas fa-info-circle me-1"></i> TENTANG
                                </button>
                            </li>
                        @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="btn btn-login" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-1"></i>{{ __('Login') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <button class="btn dropdown-toggle dropdown-toggle-custom" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item dropdown-item-custom" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                        </a>
                                    </li>
                                </ul>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 mb-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
