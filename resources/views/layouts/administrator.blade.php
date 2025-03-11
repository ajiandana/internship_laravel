<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <style>
        body {
            background-image: url("{{ asset('img/bg.jpg') }}");
            background-size: cover;
        }

        .dashboard-bg {
            background-image: url("{{ asset('img/background_admin.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .nav-link.active {
            font-weight: bold;
            color: #fff !important;
            background-color: #007bff;
            border-radius: 5px;
            padding: 8px 16px;
            transition: background-color 0.3s ease;
        }
        .nav-link:hover {
            background-color: #0056b3;
            border-radius: 5px;
            color: #fff !important;
        }
    </style>
</head>
<body class="{{ request()->routeIs('dashboard') ? 'dashboard-bg' : '' }}">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-user-shield"></i> Administrator Panel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('instansi.index') || request()->routeIs('instansi.create') || request()->routeIs('instansi.edit') ? 'active' : '' }}" href="{{ route('instansi.index') }}">
                            <i class="fas fa-building"></i> Instansi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="fas fa-users"></i> Data User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mentorings.index') || request()->routeIs('mentorings.create') || request()->routeIs('mentorings.edit') ? 'active' : '' }}" href="{{ route('mentorings.index') }}">
                            <i class="fas fa-handshake"></i> Mentoring
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('parameters.index') || request()->routeIs('parameters.create') || request()->routeIs('parameters.edit') ? 'active' : '' }}" href="{{ route('parameters.index') }}">
                            <i class="fas fa-list-alt"></i> Parameter Penilaian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('indikator-grups.index') || request()->routeIs('indikator-grups.create') || request()->routeIs('indikator-grups.edit') ? 'active' : '' }}" href="{{ route('indikator-grups.index') }}">
                            <i class="fas fa-chart-bar"></i> Jenis Indikator
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>