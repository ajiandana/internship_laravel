@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2>Tambah Instansi</h2>
    <form action="{{ route('instansi.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_instansi">Nama Instansi</label>
            <input type="text" name="nama_instansi" id="nama_instansi" class="form-control" required>
        </div>
        <div style="margin-bottom: 15px;"></div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('instansi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection