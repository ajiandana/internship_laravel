@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-building"></i> Instansi</h2>
    <a href="{{ route('instansi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Instansi
    </a>
    <div style="margin-bottom: 15px;"></div>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama Instansi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($instansi as $item)
            <tr>
                <td>{{ $item->nama_instansi }}</td>
                <td>
                    <a href="{{ route('instansi.edit', $item->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('instansi.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
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