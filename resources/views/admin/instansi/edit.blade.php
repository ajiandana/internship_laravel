@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2>Edit Instansi</h2>
    <form action="{{ route('instansi.update', $instansi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_instansi">Nama Instansi</label>
            <input type="text" name="nama_instansi" id="nama_instansi" class="form-control" value="{{ $instansi->nama_instansi }}" required>
        </div>
        <div style="margin-bottom: 15px;"></div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('instansi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection