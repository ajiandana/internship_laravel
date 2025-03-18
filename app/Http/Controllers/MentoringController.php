<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mentoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentoringController extends Controller
{
    public function index()
    {
        $mentorings = Mentoring::with(['student', 'mentor'])->get();
        return view('admin.mentorings.index', compact('mentorings'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->where('status', 'Aktif')->get();
        $mentors = User::where('role', 'mentor')->get();
        return view('admin.mentorings.create', compact('students', 'mentors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
        ]);

        Mentoring::create($request->all());

        return redirect()->route('mentorings.index')->with('success', 'Mentoring berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Mentoring $mentoring)
    {
        $students = User::where('role', 'student')->get();
        $mentors = User::where('role', 'mentor')->get();
        return view('admin.mentorings.edit', compact('mentoring', 'students', 'mentors'));
    }

    public function update(Request $request, Mentoring $mentoring)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
        ]);

        $mentoring->update($request->all());

        return redirect()->route('mentorings.index')->with('success', 'Mentoring berhasil diperbarui!');
    }

    public function destroy(Mentoring $mentoring)
    {
        $mentoring->delete();
        return redirect()->route('mentorings.index')->with('success', 'Mentoring berhasil dihapus!');
    }

    public function selesaiMagang($studentId)
    {
        dd("Masuk ke fungsi selesaiMagang dengan studentId: " . $studentId);
        $student = User::findOrFail($studentId);
        $student->update(['status' => 'Tidak Aktif']);

        // Mentoring::where('student_id', $studentId)->delete();

        return redirect()->route('mentorings.index')->with('success', 'Student telah menyelesaikan magang!');
    }
}