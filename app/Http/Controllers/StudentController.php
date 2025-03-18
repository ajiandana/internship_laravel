<?php

namespace App\Http\Controllers;

use App\Models\Mentoring;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\MasterInstansi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::user();
        return view('student.dashboard', compact('student'));
    }

    public function dataDiri()
    {
        $student = Auth::user();
        $instansi = MasterInstansi::all();
        return view('student.data_diri', compact('student', 'instansi'));
    }

    public function simpanDataDiri(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'no_identitas' => 'required|string|max:50',
            'instansi_id' => 'required|exists:master_instansi,id',
        ]);

        $student = Auth::user();
        $student->update([
        'nama_lengkap' => $request->nama_lengkap,
        'no_identitas' => $request->no_identitas,
        'instansi_id' => $request->instansi_id,
        ]);

        return redirect()->route('student.data-diri')->with('success', 'Data diri berhasil diperbarui!');
    }

    public function nilaiSaya()
    {
        $student = Auth::user();
        $penilaian = Penilaian::where('student_id', $student->id)->get();
    
        // Cari mentor dari data mentoring
        $mentor = null;
        if ($student->mentoring) {
            $mentor = $student->mentoring->mentor;
        } else {
            // Jika tidak ada data mentoring, cari mentor dari tabel penilaian
            if ($penilaian->isNotEmpty()) {
                $mentor = $penilaian->first()->mentor;
            }
        }
    
        return view('student.nilai_saya', compact('student', 'penilaian', 'mentor'));
    }

    public function getMentorName()
    {
        $student = Auth::user();;
        $mentor =  $student->mentoring->mentor;
        $mentoring = Mentoring::where('mentor_id', $mentor->id)
        ->with(['student.mentoring.mentor'])
        ->get();

        return view('student.nilai_saya', compact('mentoriname'));
    }

    public function exportNilaiPDF()
    {
        $student = Auth::user();
        $penilaian = Penilaian::where('student_id', $student->id)->get();

        // Cari mentor dari data mentoring atau penilaian
        $mentor = null;
        if ($student->mentoring) {
            $mentor = $student->mentoring->mentor;
        } else {
            if ($penilaian->isNotEmpty()) {
                $mentor = $penilaian->first()->mentor;
            }
        }

        // Load view ke PDF
        $pdf = Pdf::loadView('student.export_nilai_pdf', compact('student', 'penilaian', 'mentor'));

        // Download PDF
        return $pdf->download('nilai-saya.pdf');
    }
}
