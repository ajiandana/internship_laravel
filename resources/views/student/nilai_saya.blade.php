@extends('layouts.student')

@section('content')
<div class="container mt-4">
    <h2>Nilai Saya</h2>
    @if ($mentor)
        <div class="card shadow-sm border-0">
            <div class="card-body p-4" style="background: #f8f9fa; border-radius: 10px;">
                <h5 class="card-title text-primary">
                    <p class="form-control-plaintext">Mentor</p>
                </h5>
                <hr>
                <h5 class="card-title text-primary">
                    <i class="bi bi-person-circle"></i>{{ $mentor->nama_lengkap }}
                </h5>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Anda belum memiliki mentor.
        </div>
    @endif
    
    @if ($penilaian->isEmpty())
        <div class="alert alert-info">
            Anda belum menyelesaikan masa magang.
        </div>
    @else
    
    <div style="margin-bottom: 10px;"></div>
        <table class="table table-striped table-hover mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Parameter</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaian as $nilai)
                <tr>
                    <td>{{ $nilai->parameter->nama_parameter }}</td>
                    <td>{{ $nilai->nilai->skor }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection