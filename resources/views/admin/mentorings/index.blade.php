@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-handshake"></i> Data Mentoring</h2>
    <a href="{{ route('mentorings.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Mentoring
    </a>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Student</th>
                <th>Mentor</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mentorings as $mentoring)
            <tr>
                <td>{{ $mentoring->student->nama_lengkap }}</td>
                <td>{{ $mentoring->mentor->nama_lengkap }}</td>
                <td>
                    <a href="{{ route('mentorings.edit', $mentoring->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('mentorings.destroy', $mentoring->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection