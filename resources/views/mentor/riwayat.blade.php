@extends('layouts.mentor')

@section('content')
<div class="container">
    <h2 class="text-center mt-4 mb-4">Riwayat Penilaian</h2>

    @if ($riwayatPenilaian->isEmpty())
        <div class="alert alert-info text-center">
            Anda belum memberikan penilaian kepada mahasiswa.
        </div>
    @else
        <div class="row">
            @foreach ($riwayatPenilaian as $studentId => $nilaiStudent)
                @php
                    $student = $nilaiStudent->first()->student;
                @endphp
                <div class="col-md-4 mb-4">
                    <div class="card card-hover">
                        <div class="card-body text-center">
                            <div class="avatar mb-3">
                                <i class="fas fa-user-circle fa-4x text-primary"></i>
                            </div>
                            <h5 class="card-title">{{ $student->nama_lengkap }}</h5>
                            <p class="card-text text-muted">{{ $student->instansi->nama_instansi }}</p>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNilai{{ $studentId }}">
                                <i class="fas fa-eye"></i> Lihat Nilai
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk menampilkan detail nilai -->
                <div class="modal fade" id="modalNilai{{ $studentId }}" tabindex="-1" aria-labelledby="modalNilaiLabel{{ $studentId }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalNilaiLabel{{ $studentId }}">
                                    <i class="fas fa-star"></i> Detail Nilai - {{ $student->nama_lengkap }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <p><strong>Nama:</strong> {{ $student->nama_lengkap }}</p>
                                        <p><strong>No. Identitas:</strong> {{ $student->no_identitas }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Instansi:</strong> {{ $student->instansi->nama_instansi }}</p>
                                        <p><strong>Mentor:</strong> {{ Auth::user()->nama_lengkap }}</p>
                                    </div>
                                </div>
                                
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Skor</th>
                                            <th>Hari, Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nilaiStudent as $nilai)
                                            <tr>
                                                <td>{{ $nilai->parameter->nama_parameter }}</td>
                                                <td>
                                                    <span class="badge bg-success">{{ $nilai->nilai->skor }}</span>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($nilai->updated_at)->locale('id')->translatedFormat('l, d F Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('mentor.riwayat.export-pdf', ['studentId' => $studentId]) }}" class="btn btn-success me-2">
                                    <i class="fas fa-file-pdf"></i> Unduh PDF
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection