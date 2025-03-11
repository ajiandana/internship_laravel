@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2>Edit User</h2>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ $user->nama_lengkap }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="no_identitas">No. Identitas</label>
            <input type="text" name="no_identitas" id="no_identitas" class="form-control" value="{{ $user->no_identitas }}" required>
        </div>
        <div class="form-group">
            <label for="instansi_id">Instansi</label>
            <select name="instansi_id" id="instansi_id" class="form-control" required>
                @foreach ($instansi as $item)
                    <option value="{{ $item->id }}" {{ $user->instansi_id == $item->id ? 'selected' : '' }}>{{ $item->nama_instansi }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="mentor" {{ $user->role == 'mentor' ? 'selected' : '' }}>Mentor</option>
                <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
            </select>
        </div>
        <div style="margin-bottom: 15px;"></div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection