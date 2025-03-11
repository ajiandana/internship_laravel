@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2>Tambah Parameter Penilaian</h2>
    <form action="{{ route('parameters.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_parameter">Nama Parameter</label>
            <input type="text" name="nama_parameter" id="nama_parameter" class="form-control" required>
        </div>
        <div style="margin-bottom: 15px;"></div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('parameters.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection