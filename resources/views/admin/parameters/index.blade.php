@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-list-alt"></i> Parameter Penilaian</h2>
    <a href="{{ route('parameters.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Parameter
    </a>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama Parameter</th>
                <th>Aksi Kamisan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parameters as $parameter)
            <tr>
                <td>{{ $parameter->nama_parameter }}</td>
                <td>
                    <a href="{{ route('parameters.edit', $parameter->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('parameters.destroy', $parameter->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection