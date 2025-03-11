<?php

namespace App\Http\Controllers;

// use Illuminate\Container\Attributes\Auth;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\MasterInstansi;
use App\Models\Mentoring;
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
        $student = Auth::user();;
        $penilaian = Penilaian::where('student_id', $student->id)->get();
        $mentor = null;
        if ($student->mentoring) {
            $mentor = $student->mentoring->mentor;
        }

        return view('student.nilai_saya', compact('student', 'penilaian', 'mentor'));
        // $penilaian = Penilaian::where('student_id', $student->id)
        // ->with(['parameter', 'nilai', 'student.mentoring.mentor'])
        // ->get();

        // return view('student.nilai_saya', compact('student', 'penilaian'));
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
}
