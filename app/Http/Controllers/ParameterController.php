<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterParameter;

class ParameterController extends Controller
{
    public function index()
    {
        $parameters = MasterParameter::all();
        return view('admin.parameters.index', compact('parameters'));
    }

    public function create()
    {
        return view('admin.parameters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_parameter' => 'required|string|max:100',
        ]);

        MasterParameter::create($request->all());

        return redirect()->route('parameters.index')->with('success', 'Parameter berhasil ditambahkan!');
    }

    public function show(MasterParameter $parameter)
    {
        return view('admin.parameters.show', compact('parameter'));
    }

    public function edit(MasterParameter $parameter)
    {
        return view('admin.parameters.edit', compact('parameter'));
    }

    public function update(Request $request, MasterParameter $parameter)
    {
        $request->validate([
            'nama_parameter' => 'required|string|max:100',
        ]);

        $parameter->update($request->all());

        return redirect()->route('parameters.index')->with('success', 'Parameter berhasil diperbarui!');
    }

    public function destroy(MasterParameter $parameter)
    {
        $parameter->delete();
        return redirect()->route('parameters.index')->with('success', 'Parameter berhasil dihapus!');
    }
}
