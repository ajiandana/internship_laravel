@extends('layouts.mentor')

@section('content')
<div class="container">
    <h1>Form Penilaian</h1>
    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="indikator_grup_id">Jenis Indikator</label>
            <select name="indikator_grup_id" id="indikator_grup_id" class="form-control" required>
                <option value="">Pilih Jenis Indikator</option>
                @foreach ($indikatorGrups as $indikatorGrup)
                    <option value="{{ $indikatorGrup->id }}">{{ $indikatorGrup->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="nilai_id">Nilai</label>
            <div id="nilai-options">
                <!-- Nilai akan diisi secara dinamis menggunakan JavaScript -->
            </div>
        </div>
        <div class="form-group">
            <label for="parameter">Parameter</label>
            <input type="text" name="parameter" id="parameter" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    document.getElementById('indikator_grup_id').addEventListener('change', function() {
        const indikatorGrupId = this.value;
        const nilaiOptions = document.getElementById('nilai-options');

        if (indikatorGrupId) {
            fetch(`/api/nilai-indikator/${indikatorGrupId}`)
                .then(response => response.json())
                .then(data => {
                    nilaiOptions.innerHTML = '';
                    data.forEach(nilai => {
                        nilaiOptions.innerHTML += `
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="nilai_id" id="nilai-${nilai.id}" value="${nilai.id}" required>
                                <label class="form-check-label" for="nilai-${nilai.id}">${nilai.nilai}</label>
                            </div>
                        `;
                    });
                });
        } else {
            nilaiOptions.innerHTML = '';
        }
    });
</script>
@endsection