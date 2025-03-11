@extends('layouts.mentor')

@section('content')
<div class="container mt-4">
    <div style="margin-bottom: 15px;"></div>
    <h2>Daftar Student yang Anda mentori</h2>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>No. Identitas</th>
                <th>Instansi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->nama_lengkap }}</td>
                <td>{{ $student->no_identitas }}</td>
                <td>{{ $student->instansi->nama_instansi }}</td>
                <td>
                    <a href="{{ route('mentor.penilaian', $student->id) }}" class="btn btn-primary">Penilaian</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection