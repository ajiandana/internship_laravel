<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mentoring;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Models\MasterParameter;
use App\Models\MasterIndikatorGrup;
use Illuminate\Support\Facades\Auth;

class MentorController extends Controller
{
    public function dashboard()
    {
        return view('mentor.dashboard');
    }

    public function daftarStudent()
    {
        $mentor = Auth::user();

        $students = Mentoring::where('mentor_id', $mentor->id)
            ->with('student')
            ->get()
            ->pluck('student');

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

    public function riwayat()
    {
        $mentor = Auth::user();
        $riwayatPenilaian = Penilaian::whereHas('student', function ($query) use ($mentor) {
            $query->where('mentor_id', $mentor->id);
        })
        ->with(['student', 'indikatorGrup', 'parameter', 'nilai'])
        ->get();
        return view('mentor.riwayat', compact('riwayatPenilaian'));
    }
}
