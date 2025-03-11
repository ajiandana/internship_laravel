@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2>Tambah Jenis Indikator</h2>
    <form action="{{ route('indikator-grups.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
        </div>
        <div style="margin-bottom: 10px;"></div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('indikator-grups.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection