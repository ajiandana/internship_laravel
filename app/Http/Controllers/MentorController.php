<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mentoring;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\MasterParameter;
use App\Models\MasterIndikatorGrup;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class MentorController extends Controller
{
    public function dashboard()
    {
        return view('mentor.dashboard');
    }

    public function daftarStudent()
    {
        $mentor = Auth::user();
        $students = User::where('role', 'student')
        ->where('status', 'Aktif')
        ->whereHas('mentoring', function ($query) use ($mentor) {
            $query->where('mentor_id', $mentor->id);
        })
        ->get();

        if ($students->isEmpty()) {
            return view('mentor.daftar_student', compact('students'))->with('info', 'Tidak ada student yang sedang Anda mentori.');
        }

        return view('mentor.daftar_student', compact('students'));
    }

    public function penilaian($studentId)
    {
        $student = User::findOrFail($studentId);
        $indikatorGrups = MasterIndikatorGrup::with('indikatorNilai')->get();
        $parameters = MasterParameter::all();

        $mentor = Auth::user();
        $penilaianExist = Penilaian::where('student_id', $studentId)
            ->whereHas('student', function ($query) use ($mentor) {
                $query->where('mentor_id', $mentor->id);
            })
            ->exists();

        return view('mentor.penilaian', compact('student', 'indikatorGrups', 'parameters', 'penilaianExist'));
    }

    public function simpanPenilaian(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'indikator_grup_id' => 'required|exists:master_indikator_grups,id',
            'parameter_ids' => 'required|array',
            'parameter_ids.*' => 'exists:master_parameters,id',
            'skor' => 'required|array',
            'skor.*' => 'exists:master_indikator_nilais,id',
        ]);

        $mentor = Auth::user();
        foreach ($request->parameter_ids as $parameterId) {
            Penilaian::create([
                'student_id' => $request->student_id,
                'mentor_id' => $mentor->id,
                'indikator_grup_id' => $request->indikator_grup_id,
                'parameter_id' => $parameterId,
                'nilai_id' => $request->skor[$parameterId],
            ]);
        }

        return redirect()->route('mentor.riwayat')->with('success', 'Penilaian berhasil disimpan!');
    }

    public function editPenilaian($studentId)
    {
        $student = User::findOrFail($studentId);
        $indikatorGrups = MasterIndikatorGrup::with('indikatorNilai')->get();
        $parameters = MasterParameter::all();

        $mentor = Auth::user();
        $penilaian = Penilaian::where('student_id', $studentId)
            ->whereHas('student', function ($query) use ($mentor) {
                $query->where('mentor_id', $mentor->id);
            })
            ->get();

        return view('mentor.edit_penilaian', compact('student', 'indikatorGrups', 'parameters', 'penilaian'));
    }

    public function updatePenilaian(Request $request, $studentId)
    {
        $request->validate([
            'indikator_grup_id' => 'required|exists:master_indikator_grups,id',
            'parameter_ids' => 'required|array',
            'parameter_ids.*' => 'exists:master_parameters,id',
            'skor' => 'required|array',
            'skor.*' => 'exists:master_indikator_nilais,id',
        ]);

        $mentor = Auth::user();
        $penilaianExist = Penilaian::where('student_id', $studentId)
            ->whereHas('student', function ($query) use ($mentor) {
                $query->where('mentor_id', $mentor->id);
            })
            ->get();

        $parameterIdsDipilih = $request->parameter_ids;
        foreach ($penilaianExist as $nilai) {
            if (!in_array($nilai->parameter_id, $parameterIdsDipilih)) {
                $nilai->delete();
            }
        }

        foreach ($request->parameter_ids as $parameterId) {
            $penilaian = $penilaianExist->where('parameter_id', $parameterId)->first();

            if ($penilaian) {
                $penilaian->update([
                    'indikator_grup_id' => $request->indikator_grup_id,
                    'nilai_id' => $request->skor[$parameterId],
                ]);
            } else {
                Penilaian::create([
                    'student_id' => $studentId,
                    'mentor_id' => $mentor->id,
                    'indikator_grup_id' => $request->indikator_grup_id,
                    'parameter_id' => $parameterId,
                    'nilai_id' => $request->skor[$parameterId],
                ]);
            }
        }

        return redirect()->route('mentor.riwayat')->with('success', 'Penilaian berhasil diperbarui!');
    }

    public function updateStatus(Request $request, $studentId)
    {
        $request->validate([
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);
    
        $student = User::findOrFail($studentId);
        $student->update(['status' => $request->status]);

        $mentor = Auth::user();
        $allStudentsInactive = User::where('role', 'student')
        ->whereHas('mentoring', function ($query) use ($mentor) {
            $query->where('mentor_id', $mentor->id);
        })
        ->where('status', 'Aktif')
        ->doesntExist();

        if ($allStudentsInactive) {
            Mentoring::where('mentor_id', $mentor->id)->delete();
        }

        $hasRating = Penilaian::where('student_id', $studentId)
                          ->where('mentor_id', $mentor->id)
                          ->exists();

        if (!$hasRating && $request->status === 'Tidak Aktif') {
            return response()->json(['success' => false, 'message' => 'Anda belum memberikan penilaian.']);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui.',
        ]);
    }

    public function checkRating($studentId)
    {
        $mentor = Auth::user();
        $hasRating = Penilaian::where('student_id', $studentId)
                            ->where('mentor_id', $mentor->id)
                            ->exists();

        return response()->json(['hasRating' => $hasRating]);
    }

    public function riwayat()
    {
        $mentor = Auth::user();
        $riwayatPenilaian = Penilaian::whereHas('student', function ($query) use ($mentor) {
                $query->where('mentor_id', $mentor->id);
            })
            ->with(['student', 'parameter', 'nilai'])
            ->get()
            ->groupBy('student_id');

        return view('mentor.riwayat', compact('riwayatPenilaian'));
    }

    public function exportRiwayatPDF($studentId)
    {
        $mentor = Auth::user();
        $student = User::with('instansi')->findOrFail($studentId);
        $penilaian = Penilaian::with(['parameter', 'nilai'])
            ->where('student_id', $studentId)
            ->where('mentor_id', $mentor->id)
            ->get();

        $pdf = Pdf::loadView('mentor.pdf.riwayat_penilaian', [
            'student' => $student,
            'penilaian' => $penilaian,
            'mentor' => $mentor
        ]);

        return $pdf->download('riwayat-nilai-'.$student->nama_lengkap.'.pdf');
    }
}