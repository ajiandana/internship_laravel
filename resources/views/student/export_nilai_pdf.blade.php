<!DOCTYPE html>
<html>
<head>
    <title>Penilaian Magang</title>
    <style>
        /* Header dengan Gambar Kop */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100%;
            max-width: 800px;
            height: auto;
        }

        /* Body */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        /* Card untuk Data Diri dan Mentor */
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card h4 {
            font-size: 1.25rem;
            color: #007bff;
            margin-bottom: 15px;
        }
        .card p {
            margin: 5px 0;
            font-size: 1rem;
            color: #333;
        }
        .card .data-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .card .data-item strong {
            width: 150px; /* Lebar tetap untuk label */
        }
        .card .data-item span {
            flex-grow: 1; /* Teks mengisi sisa ruang */
        }

        /* Tabel Nilai */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .text-center {
            text-align: center;
        }
        .text-primary {
            color: #007bff;
        }
        .text-muted {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/kop.jpg') }}" alt="Kop Surat">
    </div>

    <h2 class="text-center text-primary mb-4">Penilaian Magang</h2>
    <div class="card">
        <table>
            <tr>
                <td>Nama</td>
                <td>: <strong>{{ $student->nama_lengkap }}</strong></td>
            </tr>
            <tr>
                <td>No. Identitas</td>
                <td>: <strong>{{ $student->no_identitas }}</strong></td>
            </tr>
            <tr>
                <td>Instansi</td>
                <td>: <strong>{{ $student->instansi->nama_instansi }}</strong></td>
            </tr>
            @if ($mentor)
            <tr>
                <td>Mentor</td>
                <td>: <strong>{{ $mentor->nama_lengkap }}</strong></td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Tabel Nilai -->
    @if ($penilaian->isNotEmpty())
        <div>
            <h4 class="text-primary">Detail Nilai</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penilaian as $nilai)
                        <tr>
                            <td>{{ $nilai->parameter->nama_parameter }}</td>
                            <td>
                                <span class="badge badge-success">{{ $nilai->nilai->skor }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            Anda belum menyelesaikan masa magang.
        </div>
    @endif
</body>
</html>