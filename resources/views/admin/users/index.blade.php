@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-users"></i> Data User</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah User
    </a>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Instansi</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->nama_lengkap }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->instansi->nama_instansi }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection