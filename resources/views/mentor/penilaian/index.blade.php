@extends('layouts.mentor')

@section('content')
<div class="container">
    <h1>Penilaian</h1>
    <form action="{{ route('mentor.simpanPenilaian') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
        @foreach ($indikatorGrups as $indikatorGrup)
            <div class="form-group">
                <label>{{ $indikatorGrup->nama }}</label>
                @foreach ($indikatorGrup->indikatorNilai as $nilai)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="nilai[{{ $indikatorGrup->id }}]" value="{{ $nilai->id }}" required>
                        <label class="form-check-label">{{ $nilai->nilai }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
    </form>
</div>
@endsection