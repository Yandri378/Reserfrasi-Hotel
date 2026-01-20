<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Reservasi Hotel</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f5f5f5;
        }
        
        .navbar {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .sidebar {
            background-color: #2c3e50;
            color: white;
            min-height: calc(100vh - 56px);
            padding-top: 20px;
        }
        
        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #34495e;
            border-left-color: #3498db;
            color: #fff;
        }
        
        .sidebar .section-title {
            color: #95a5a6;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 15px 20px 10px;
            margin-top: 15px;
        }
        
        .content-area {
            background-color: #f5f5f5;
            min-height: calc(100vh - 56px);
        }
        
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .card-header {
            background-color: #3498db;
            color: white;
            border: none;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-hotel"></i> Hotel Reservation
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="row g-0">
        <!-- Sidebar -->
        @auth
            <div class="col-md-2">
                <div class="sidebar">
                    <div class="section-title">Menu</div>
                    <a href="{{ route('home') }}" class="@if(Route::currentRouteName() == 'home') active @endif">
                        <i class="fas fa-dashboard"></i> Dashboard
                    </a>
                    <a href="{{ route('reservasi.index') }}" class="@if(str_contains(Route::currentRouteName(), 'reservasi')) active @endif">
                        <i class="fas fa-list"></i> Daftar Reservasi
                    </a>
                    <a href="{{ route('reservasi.create') }}" class="@if(Route::currentRouteName() == 'reservasi.create') active @endif">
                        <i class="fas fa-plus-circle"></i> Tambah Reservasi
                    </a>

                    <div class="section-title">Laporan</div>
                    <a href="{{ route('analytics.dashboard') }}" class="@if(Route::currentRouteName() == 'analytics.dashboard') active @endif">
                        <i class="fas fa-chart-bar"></i> Analytics
                    </a>
                    <a href="{{ route('laporan.bulanan') }}" class="@if(Route::currentRouteName() == 'laporan.bulanan') active @endif">
                        <i class="fas fa-calendar"></i> Laporan Bulanan
                    </a>
                    <a href="{{ route('laporan.tahunan') }}" class="@if(Route::currentRouteName() == 'laporan.tahunan') active @endif">
                        <i class="fas fa-calendar-year"></i> Laporan Tahunan
                    </a>

                    <div class="section-title">Admin</div>
                    <a href="{{ route('admin.dashboard') }}" class="@if(str_contains(Route::currentRouteName(), 'admin')) active @endif">
                        <i class="fas fa-user-shield"></i> Admin Dashboard
                    </a>
                    <a href="{{ route('admin.all-reservasi') }}" class="@if(Route::currentRouteName() == 'admin.all-reservasi') active @endif">
                        <i class="fas fa-list-check"></i> Manajemen Reservasi
                    </a>
                </div>
            </div>
        @endauth

        <!-- Content -->
        <div class="@auth col-md-10 @else col-md-12 @endauth content-area">
            <div class="container-fluid py-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Ada kesalahan!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
