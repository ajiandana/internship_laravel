<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mentor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <style>
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
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('mentor.dashboard') }}">
                <i class="fas fa-user-shield"></i> Mentor Panel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mentor.daftar-student') || request()->routeIs('mentor.penilaian') || request()->routeIs('mentor.edit-penilaian') ? 'active' : '' }}" href="{{ route('mentor.daftar-student') }}">
                            <i class="fas fa-building"></i> Penilaian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mentor.riwayat') ? 'active' : '' }}" href="{{ route('mentor.riwayat') }}">
                            <i class="fas fa-users"></i> Riwayat Penilaian
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

    <div class="container-fluid p-0">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>