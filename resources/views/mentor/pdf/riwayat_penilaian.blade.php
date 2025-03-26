<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-width: 100%; height: auto; }
        h2 { color: #2c3e50; text-align: center; margin-bottom: 20px; }
        .data-info { margin-bottom: 30px; }
        .data-info p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #3498db; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border: 1px solid #ddd; }
        .badge { background-color: #2ecc71; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.9em; }
        .text-center { text-align: center; }
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
                <td><strong>{{ $student->nama_lengkap }}</strong></td>
            </tr>
            <tr>
                <td>No. Identitas</td>
                <td><strong>{{ $student->no_identitas }}</strong></td>
            </tr>
            <tr>
                <td>Instansi</td>
                <td><strong>{{ $student->instansi->nama_instansi }}</strong></td>
            </tr>
            @if ($mentor)
            <tr>
                <td>Mentor</td>
                <td><strong>{{ $mentor->nama_lengkap }}</strong></td>
            </tr>
            @endif
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Parameter</th>
                <th>Skor</th>
                <th>Tanggal Penilaian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penilaian as $nilai)
            <tr>
                <td>{{ $nilai->parameter->nama_parameter }}</td>
                <td><span class="badge">{{ $nilai->nilai->skor }}</span></td>
                <td>{{ \Carbon\Carbon::parse($nilai->updated_at)->locale('id')->translatedFormat('l, d F Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 40px; text-align: right;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>{{ $mentor->nama_lengkap }}</strong></p>
        <p>Mentor</p>
    </div>
</body>
</html>