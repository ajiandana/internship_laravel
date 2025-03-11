@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2>Edit Jenis Indikator</h2>
    <form action="{{ route('indikator-grups.update', $indikatorGrup->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ $indikatorGrup->nama }}" required>
        </div>
        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ $indikatorGrup->keterangan }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Update</button>
        <a href="{{ route('indikator-grups.index') }}" class="btn btn-secondary  mt-4">Kembali</a>
    </form>
</div>
@endsection