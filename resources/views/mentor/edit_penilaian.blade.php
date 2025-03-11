@extends('layouts.mentor')

@section('content')
<div class="container mt-4">
    <h2>Edit Penilaian Magang</h2>
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
        <h3>Edit Detail Nilai</h3>
        <form action="{{ route('mentor.update-penilaian', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Pilih Indikator Grup (Radio Button) -->
            <div class="form-group">
                <label><strong>Jenis Indikator:</strong></label>
                @foreach ($indikatorGrups as $grup)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="indikator_grup_id" id="indikator_grup_{{ $grup->id }}" value="{{ $grup->id }}" required
                            {{ $penilaian->first()->indikator_grup_id == $grup->id ? 'checked' : '' }}>
                        <label class="form-check-label" for="indikator_grup_{{ $grup->id }}">
                            {{ $grup->nama }}
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- Daftar Parameter dengan Checkbox -->
            <div class="form-group">
                <label><strong>Pilih Parameter:</strong></label>
                @foreach ($parameters as $parameter)
                    <div class="form-check">
                        <input class="form-check-input parameter-checkbox" type="checkbox" name="parameter_ids[]" id="parameter_{{ $parameter->id }}" value="{{ $parameter->id }}"
                            {{ $penilaian->where('parameter_id', $parameter->id)->isNotEmpty() ? 'checked' : '' }}>
                        <label class="form-check-label" for="parameter_{{ $parameter->id }}">
                            {{ $parameter->nama_parameter }}
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- Daftar Parameter Penilaian (Akan Ditampilkan Jika Dipilih) -->
            <div id="parameter-list">
                @foreach ($parameters as $parameter)
                    @if ($penilaian->where('parameter_id', $parameter->id)->isNotEmpty())
                        <div class="parameter-item mb-3" data-parameter-id="{{ $parameter->id }}">
                            <div class="form-group">
                                <label><strong>Parameter Penilaian:</strong> {{ $parameter->nama_parameter }}</label>
                                <select name="skor[{{ $parameter->id }}]" class="form-control nilai-select" required>
                                    <option value="">Pilih Skor</option>
                                    @foreach ($indikatorGrups as $grup)
                                        @foreach ($grup->indikatorNilai as $nilai)
                                            <option value="{{ $nilai->id }}"
                                                {{ $penilaian->where('parameter_id', $parameter->id)->first()->nilai_id == $nilai->id ? 'selected' : '' }}>
                                                {{ $nilai->skor }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div style="margin-bottom: 15px;"></div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
            <div style="margin-bottom: 15px;"></div>
        </form>
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
    // Fungsi untuk mengisi nilai skor berdasarkan indikator grup yang dipilih
    function isiNilaiSkor(grupId) {
        const nilaiSelects = document.querySelectorAll('.nilai-select');
        const nilaiData = document.querySelector(`#nilai-data div[data-grup-id="${grupId}"]`);

        nilaiSelects.forEach(select => {
            // Simpan nilai yang sudah dipilih sebelumnya
            const selectedValue = select.value;

            // Kosongkan dan isi ulang pilihan nilai
            select.innerHTML = '<option value="">Pilih Skor</option>';
            if (nilaiData) {
                nilaiData.querySelectorAll('div[data-nilai-id]').forEach(nilai => {
                    const option = document.createElement('option');
                    option.value = nilai.getAttribute('data-nilai-id');
                    option.text = nilai.textContent;
                    if (option.value === selectedValue) {
                        option.selected = true; // Set nilai yang sudah dipilih sebelumnya
                    }
                    select.appendChild(option);
                });
            }
        });
    }

    // Saat halaman dimuat, isi nilai skor berdasarkan indikator grup yang terpilih
    document.addEventListener('DOMContentLoaded', function() {
        const grupId = document.querySelector('input[name="indikator_grup_id"]:checked').value;
        isiNilaiSkor(grupId);
    });

    // Saat indikator grup diubah, isi nilai skor
    document.querySelectorAll('input[name="indikator_grup_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const grupId = this.value;
            isiNilaiSkor(grupId);
        });
    });

    // Saat parameter dipilih/dihapus, isi nilai skor
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

                // Isi nilai skor untuk select yang baru ditambahkan
                const grupId = document.querySelector('input[name="indikator_grup_id"]:checked').value;
                isiNilaiSkor(grupId);
            } else {
                // Hapus input skor untuk parameter yang tidak dipilih
                const item = parameterList.querySelector(`.parameter-item[data-parameter-id="${parameterId}"]`);
                if (item) {
                    item.remove();
                }
            }
        });
    });
</script>
@endsection