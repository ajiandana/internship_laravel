<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterIndikatorGrup;

class PenilaianController extends Controller
{
    public function create()
    {
        $indikatorGrups = MasterIndikatorGrup::with('nilai')->get();
        return view('mentor.penilaian.create', compact('indikatorGrups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'indikator_grup_id' => 'required|exists:master_indikator_grup,id',
            'nilai_id' => 'required|exists:master_indikator_nilai,id',
            'parameter' => 'required|string|max:255',
        ]);

        // Simpan data penilaian ke database (contoh: tabel penilaian)
        // Anda perlu membuat tabel penilaian terlebih dahulu
        // Contoh:
        // Penilaian::create([
        //     'mentor_id' => auth()->id(),
        //     'indikator_grup_id' => $request->indikator_grup_id,
        //     'nilai_id' => $request->nilai_id,
        //     'parameter' => $request->parameter,
        // ]);

        return redirect()->route('penilaian.riwayat')->with('success', 'Penilaian berhasil disimpan!');
    }
}
