@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2>Tambah Mentoring</h2>
    <form action="{{ route('mentorings.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="mentor_id">Mentor</label>
            <select name="mentor_id" id="mentor_id" class="form-control" required>
                @foreach ($mentors as $mentor)
                    <option value="{{ $mentor->id }}">{{ $mentor->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
        <div style="margin-bottom: 15px;"></div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('mentorings.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection