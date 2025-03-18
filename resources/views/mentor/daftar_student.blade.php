@extends('layouts.mentor')

@section('content')
<div class="container mt-4">
    <div style="margin-bottom: 15px;"></div>
    <h2>Daftar Student yang Anda Mentori</h2>

    @if (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @else
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>No. Identitas</th>
                    <th>Instansi</th>
                    <th>Aksi</th>
                    <th>Status Magang</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr id="student-row-{{ $student->id }}">
                    <td>{{ $student->nama_lengkap }}</td>
                    <td>{{ $student->no_identitas }}</td>
                    <td>{{ $student->instansi->nama_instansi }}</td>
                    <td>
                        <a href="{{ route('mentor.penilaian', $student->id) }}" class="btn btn-primary d-block w-100">Penilaian</a>              
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-warning dropdown-toggle w-100 status-btn" type="button" data-bs-toggle="dropdown" id="status-btn-{{ $student->id }}">
                                {{ $student->status == 'Tidak Aktif' ? 'Selesai' : 'Aktif' }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item status-option" href="#" data-student-id="{{ $student->id }}" data-status="Aktif">Aktif</a></li>
                                <li><a class="dropdown-item status-option" href="#" data-student-id="{{ $student->id }}" data-status="Tidak Aktif">Selesai</a></li>
                            </ul>
                        </div>                    
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="modal fade" id="confirmStatusModal" tabindex="-1" aria-labelledby="confirmStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmStatusModalLabel">Konfirmasi Ubah Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin mengubah status ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmChangeStatus">Ya, Ubah Status</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let selectedStudentId = null;
        let selectedStatus = null;

        // Tangani klik pada opsi dropdown
        document.querySelectorAll('.status-option').forEach(option => {
            option.addEventListener('click', function (e) {
                e.preventDefault();

                // Simpan student ID dan status yang dipilih
                selectedStudentId = this.getAttribute('data-student-id');
                selectedStatus = this.getAttribute('data-status');

                // Jika status yang dipilih adalah "Tidak Aktif" (Selesai), lakukan pengecekan penilaian
                if (selectedStatus === 'Tidak Aktif') {
                    fetch(`/mentor/check-rating/${selectedStudentId}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.hasRating) {
                            // Jika sudah ada penilaian, tampilkan modal konfirmasi perubahan status
                            const confirmStatusModal = new bootstrap.Modal(document.getElementById('confirmStatusModal'));
                            confirmStatusModal.show();
                        } else {
                            // Jika belum ada penilaian, tampilkan modal notifikasi
                            const noRatingModal = new bootstrap.Modal(document.getElementById('noRatingModal'));
                            noRatingModal.show();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memeriksa penilaian.');
                    });
                } else {
                    // Jika status yang dipilih bukan "Tidak Aktif", langsung tampilkan modal konfirmasi
                    const confirmStatusModal = new bootstrap.Modal(document.getElementById('confirmStatusModal'));
                    confirmStatusModal.show();
                }
            });
        });

        // Tangani klik pada tombol "Ya, Ubah Status" di modal
        document.getElementById('confirmChangeStatus').addEventListener('click', function () {
            if (selectedStudentId && selectedStatus) {
                // Kirim permintaan AJAX untuk mengubah status
                fetch(`/mentor/update-status/${selectedStudentId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: selectedStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Perbarui tampilan dropdown
                        const statusBtn = document.getElementById(`status-btn-${selectedStudentId}`);
                        statusBtn.textContent = selectedStatus === 'Tidak Aktif' ? 'Selesai' : 'Aktif';

                        // Sembunyikan baris student jika status diubah menjadi 'Tidak Aktif'
                        if (selectedStatus === 'Tidak Aktif') {
                            document.getElementById(`student-row-${selectedStudentId}`).remove();
                        }

                        alert('Status berhasil diperbarui!');
                    } else {
                        alert('Gagal memperbarui status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui status.');
                });

                // Tutup modal
                const confirmStatusModal = bootstrap.Modal.getInstance(document.getElementById('confirmStatusModal'));
                confirmStatusModal.hide();
            }
        });
    });
</script>

<!-- Modal untuk notifikasi belum ada penilaian -->
<div class="modal fade" id="noRatingModal" tabindex="-1" aria-labelledby="noRatingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noRatingModalLabel">Belum Ada Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda belum memberikan penilaian. Silakan berikan penilaian terlebih dahulu sebelum mengubah status menjadi "Selesai".
            </div>
            <div class="modal-footer">
                <a href="{{ route('mentor.penilaian', $student->id) }}" class="btn btn-primary">Isi Penilaian</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection