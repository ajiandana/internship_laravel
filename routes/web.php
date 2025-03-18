<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\MentoringController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\IndikatorGrupController;
use App\Http\Controllers\Api\IndikatorNilaiController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth', 'admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware('auth');
    Route::resource('instansi', InstansiController::class)->middleware('auth');
    Route::resource('users', UserController::class)->middleware('auth');
    Route::resource('parameters', ParameterController::class)->middleware('auth');
    Route::resource('mentorings', MentoringController::class)->middleware('auth');
    Route::resource('indikator-grups', IndikatorGrupController::class)->middleware('auth');
});

Route::middleware(['auth', 'mentor'])->group(function () {
    Route::get('/mentor/dashboard', [MentorController::class, 'dashboard'])->name('mentor.dashboard');
    Route::get('/mentor/penilaian', [MentorController::class, 'penilaian'])->name('mentor.penilaian');
    Route::get('/mentor/riwayat', [MentorController::class, 'riwayat'])->name('mentor.riwayat');
    Route::post('/mentor/simpan-penilaian', [MentorController::class, 'simpanPenilaian'])->name('mentor.simpan-penilaian');
    Route::get('/mentor/penilaian/{studentId}', [MentorController::class, 'penilaian'])->name('mentor.penilaian');
    Route::get('/mentor/daftar-student', [MentorController::class, 'daftarStudent'])->name('mentor.daftar-student');
    Route::get('/indikator-nilai/{grupId}', [IndikatorNilaiController::class, 'getNilaiByGrup']);
    Route::get('/mentor/edit-penilaian/{studentId}', [MentorController::class, 'editPenilaian'])->name('mentor.edit-penilaian');
    Route::put('/mentor/update-status/{studentId}', [MentorController::class, 'updateStatus'])->name('mentor.update-status');
    Route::get('/mentor/check-rating/{studentId}', [MentorController::class, 'checkRating'])->name('mentor.checkRating');
    Route::put('/mentor/update-penilaian/{studentId}', [MentorController::class, 'updatePenilaian'])->name('mentor.update-penilaian');
});

Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/data-diri', [StudentController::class, 'dataDiri'])->name('student.data-diri');
    Route::post('/student/simpan-data-diri', [StudentController::class, 'simpanDataDiri'])->name('student.simpan-data-diri');
    Route::get('/student/nilai-saya', [StudentController::class, 'nilaiSaya'])->name('student.nilai-saya');
    Route::get('/student/nilai/export-pdf', [StudentController::class, 'exportNilaiPDF'])->name('student.nilai.export-pdf');
});

Route::get('/', function () {   
    return view('auth.login');
});