@extends('layouts.student')

@section('content')
<div class="container mt-4">
    <h2>Data Diri</h2>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card shadow-sm border-0">
        <div class="card-body p-4" style="background: #f8f9fa; border-radius: 10px;">
            <form action="{{ route('student.simpan-data-diri') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" id="email" class="form-control" value="{{ $student->email }}" readonly>
                    </div>
                </div>
                <div style="margin-bottom: 10px;"></div>
                <div class="form-group row">
                    <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ $student->nama_lengkap }}" required>
                    </div>
                </div>
                <div style="margin-bottom: 10px;"></div>
                <div class="form-group row">
                    <label for="no_identitas" class="col-sm-2 col-form-label">No. Identitas</label>
                    <div class="col-sm-10">
                        <input type="text" name="no_identitas" id="no_identitas" class="form-control" value="{{ $student->no_identitas }}" required>
                    </div>
                </div>
                <div style="margin-bottom: 10px;"></div>
                <div class="form-group row">
                    <label for="instansi_id" class="col-sm-2 col-form-label">Instansi</label>
                    <div class="col-sm-10">
                        <select name="instansi_id" id="instansi_id" class="form-control" required>
                            <option value="">Pilih Instansi</option>
                            @foreach ($instansi as $item)
                                <option value="{{ $item->id }}" {{ $student->instansi_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_instansi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="margin-bottom: 10px;"></div>
                <div class="form-group row">
                    <label for="role" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                        <input type="text" name="role" id="role" class="form-control" value="{{ ucfirst($student->role) }}" readonly>
                    </div>
                </div>
                <div style="margin-bottom: 20px;"></div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection