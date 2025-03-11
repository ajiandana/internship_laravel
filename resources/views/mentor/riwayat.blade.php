@extends('layouts.mentor')

@section('content')
<div class="container mt-4">
    <h2>Riwayat Penilaian</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama Student</th>
                <th>Parameter</th>
                <th>Nilai</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayatPenilaian as $nilainya)
            <tr>
                <td>{{ $nilainya->student->nama_lengkap }}</td>
                <td>{{ $nilainya->parameter->nama_parameter }}</td>
                <td>{{ $nilainya->nilai->skor }}</td>
                <td>{{ $nilainya->updated_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection