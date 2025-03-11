<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterIndikatorGrup;

class IndikatorGrupController extends Controller
{
    public function index()
    {
        $indikatorGrups = MasterIndikatorGrup::all();
        return view('admin.indikator_grups.index', compact('indikatorGrups'));
    }

    public function create()
    {
        return view('admin.indikator_grups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        MasterIndikatorGrup::create($request->all());

        return redirect()->route('indikator-grups.index')->with('success', 'Jenis Indikator berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(MasterIndikatorGrup $indikatorGrup)
    {
        return view('admin.indikator_grups.edit', compact('indikatorGrup'));
    }

    public function update(Request $request, MasterIndikatorGrup $indikatorGrup)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $indikatorGrup->update($request->all());

        return redirect()->route('indikator-grups.index')->with('success', 'Jenis Indikator berhasil diperbarui!');
    }

    public function destroy(MasterIndikatorGrup $indikatorGrup)
    {
        $indikatorGrup->delete();
        return redirect()->route('indikator-grups.index')->with('success', 'Jenis Indikator berhasil dihapus!');
    }
}
