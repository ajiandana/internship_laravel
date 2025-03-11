<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterInstansi;

class InstansiController extends Controller
{
    public function index()
    {
        $instansi = MasterInstansi::all();
        return view('admin.instansi.index', compact('instansi'));
    }

    public function create()
    {
        return view('admin.instansi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required',
        ]);

        MasterInstansi::create($request->all());

        return redirect()->route('instansi.index')
                         ->with('success', 'Instansi created successfully.');
        }

    public function show(string $id)
    {
        //
    }

    public function edit(MasterInstansi $instansi)
    {
        return view('admin.instansi.edit', compact('instansi'));
    }

    public function update(Request $request, MasterInstansi $instansi)
    {
        $request->validate([
            'nama_instansi' => 'required',
        ]);

        $instansi->update($request->all());

        return redirect()->route('instansi.index')
                         ->with('success', 'Instansi updated successfully');
    }

    public function destroy(MasterInstansi $instansi)
    {
        $instansi->delete();

        return redirect()->route('instansi.index')
                         ->with('success', 'Instansi deleted successfully');
    }
}