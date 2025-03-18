@extends('layouts.student')

@section('content')
<div class="container mt-3 mb-5">
    <h2 class="text-center mb-4">Nilai Saya</h2>

    <!-- Card Mentor -->
    @if ($mentor)
        <div class="card mentor-card shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="card-title text-primary mb-3">
                    <i class="bi bi-person-circle me-2"></i> Mentor Anda
                </h5>
                <hr>
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <i class="fas fa-user-circle fa-3x text-primary"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $mentor->nama_lengkap }}</h4>
                        <p class="text-muted mb-0">{{ $mentor->instansi->nama_instansi }}</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Anda belum memiliki mentor.
        </div>
    @endif

    <!-- Tabel Nilai -->
    @if ($penilaian->isEmpty())
        <div class="alert alert-info">
            Anda belum menyelesaikan masa magang.
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h5 class="card-title text-primary mb-3">
                    <i class="bi bi-list-task me-2"></i> Detail Nilai
                </h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Parameter</th>
                                <th>Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penilaian as $nilai)
                                <tr class="table-row">
                                    <td>{{ $nilai->parameter->nama_parameter }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $nilai->nilai->skor }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    <div class="text-justify-end mt-4">
        <a href="{{ route('student.nilai.export-pdf') }}" class="btn btn-primary">
            <i class="bi bi-download me-2"></i> Unduh Nilai (PDF)
        </a>
    </div>
</div>
@endsection