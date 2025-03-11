@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2>Tambah User</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="no_identitas">No. Identitas</label>
            <input type="text" name="no_identitas" id="no_identitas" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="instansi_id">Instansi</label>
            <select name="instansi_id" id="instansi_id" class="form-control" required>
                @foreach ($instansi as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_instansi }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="mentor">Mentor</option>
                <option value="student">Student</option>
            </select>
        </div>
        <div style="margin-bottom: 15px;"></div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection