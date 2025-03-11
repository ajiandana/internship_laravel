@extends('layouts.mentor')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-center align-items-center">
        <h2>Penilaian Magang</h2>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card shadow-sm border-0">
        <div class="card-body p-4" style="background: #f8f9fa; border-radius: 10px;">
            <h5 class="card-title text-primary">
                <i class="bi bi-person-circle"></i> Informasi
            </h5>
            <hr>
            <div class="row">
                <div class="col-md-2">
                    <p class="card-text">Nama Lengkap</p>
                </div>
                <div class="col-md-8">
                    <p class="card-text">: <strong>{{ $student->nama_lengkap }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <p class="card-text">No. Identitas</p>
                </div>
                <div class="col-md-8">
                    <p class="card-text">: <strong>{{ $student->no_identitas }}</strong></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <p class="card-text">Instansi</p>
                </div>
                <div class="col-md-8">
                    <p class="card-text">: <strong>{{ $student->instansi->nama_instansi }}</strong></p>
                </div>
            </div>
        </div>
    </div>    

    <div class="mt-4">
        <h3>Detail Nilai</h3>

        @if ($penilaianExist)
            <div class="alert alert-info">
                Anda sudah memberikan penilaian untuk student ini. Silakan edit penilaian yang sudah ada.
            </div>
            <a href="{{ route('mentor.edit-penilaian', $student->id) }}" class="btn btn-warning">Edit Penilaian</a>
        @else
            <form action="{{ route('mentor.simpan-penilaian') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
            
                <!-- Pilih Parameter -->
                <div class="form-group">
                    <label><strong>Pilih Parameter:</strong></label>
                    @foreach ($parameters as $parameter)
                        <div class="form-check">
                            <input class="form-check-input parameter-checkbox" type="checkbox" name="parameter_ids[]" id="parameter_{{ $parameter->id }}" value="{{ $parameter->id }}">
                            <label class="form-check-label" for="parameter_{{ $parameter->id }}">
                                {{ $parameter->nama_parameter }}
                            </label>
                        </div>
                    @endforeach
                </div>
            
                <!-- Pilih Indikator Grup -->
                <div class="form-group">
                    <label><strong>Jenis Indikator:</strong></label>
                    @foreach ($indikatorGrups as $grup)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="indikator_grup_id" id="indikator_grup_{{ $grup->id }}" value="{{ $grup->id }}" required>
                            <label class="form-check-label" for="indikator_grup_{{ $grup->id }}">
                                {{ $grup->nama }} ({{ $grup->keterangan }})
                            </label>
                        </div>
                    @endforeach
                </div>
            
                <div id="parameter-list">

                </div>
                <div style="margin-bottom: 15px;"></div>            
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                <div style="margin-bottom: 15px;"></div>
            </form>
        @endif
    </div>
</div>

<!-- Data Nilai Indikator (Disimpan di HTML untuk diakses oleh JavaScript) -->
<div id="nilai-data" style="display: none;">
    @foreach ($indikatorGrups as $grup)
        <div data-grup-id="{{ $grup->id }}">
            @foreach ($grup->indikatorNilai as $nilai)
                <div data-nilai-id="{{ $nilai->id }}">{{ $nilai->skor }}</div>
            @endforeach
        </div>
    @endforeach
</div>

<script>
    // JavaScript untuk menambahkan parameter dan skor secara dinamis
    document.querySelectorAll('.parameter-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const parameterId = this.value;
            const parameterList = document.getElementById('parameter-list');

            if (this.checked) {
                // Tambahkan input skor untuk parameter yang dipilih
                const template = `
                    <div class="parameter-item mb-3" data-parameter-id="${parameterId}">
                        <div class="form-group">
                            <label><strong>Parameter Penilaian:</strong> ${this.nextElementSibling.textContent}</label>
                            <select name="skor[${parameterId}]" class="form-control nilai-select" required>
                                <option value="">Pilih Skor</option>
                                <!-- Nilai akan diisi secara dinamis berdasarkan indikator grup yang dipilih -->
                            </select>
                        </div>
                    </div>
                `;
                parameterList.insertAdjacentHTML('beforeend', template);
            } else {
                const item = parameterList.querySelector(`.parameter-item[data-parameter-id="${parameterId}"]`);
                if (item) {
                    item.remove();
                }
            }
        });
    });

    // JavaScript untuk mengisi nilai skor berdasarkan indikator grup yang dipilih
    document.querySelectorAll('input[name="indikator_grup_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const grupId = this.value;
            const nilaiSelects = document.querySelectorAll('.nilai-select');

            const nilaiData = document.querySelector(`#nilai-data div[data-grup-id="${grupId}"]`);

            nilaiSelects.forEach(select => {
                select.innerHTML = '<option value="">Pilih Skor</option>';
                if (nilaiData) {
                    nilaiData.querySelectorAll('div[data-nilai-id]').forEach(nilai => {
                        const option = document.createElement('option');
                        option.value = nilai.getAttribute('data-nilai-id');
                        option.text = nilai.textContent;
                        select.appendChild(option);
                    });
                }
            });
        });
    });
</script>
@endsection