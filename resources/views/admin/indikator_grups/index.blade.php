@extends('layouts.administrator')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">
        <i class="fas fa-chart-bar"></i> Jenis Indikator
    </h2>
    <a href="{{ route('indikator-grups.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Jenis Indikator
    </a>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($indikatorGrups as $indikatorGrup)
            <tr>
                <td>{{ $indikatorGrup->nama }}</td>
                <td>{{ $indikatorGrup->keterangan }}</td>
                <td>
                    <a href="{{ route('indikator-grups.edit', $indikatorGrup->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('indikator-grups.destroy', $indikatorGrup->id) }}" method="POST" style="display:inline;">
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