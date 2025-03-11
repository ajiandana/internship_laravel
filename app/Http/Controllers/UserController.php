<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MasterInstansi;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('instansi')->get(); 
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $instansi = MasterInstansi::all();
        return view('admin.users.create', compact('instansi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'no_identitas' => 'required|string|max:50',
            'instansi_id' => 'required|exists:master_instansi,id',
            'role' => 'required|in:admin,mentor,student',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_identitas' => $request->no_identitas,
            'instansi_id' => $request->instansi_id,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $instansi = MasterInstansi::all();
        return view('admin.users.edit', compact('user', 'instansi'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'no_identitas' => 'required|string|max:50',
            'instansi_id' => 'required|exists:master_instansi,id',
            'role' => 'required|in:admin,mentor,student',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_identitas' => $request->no_identitas,
            'instansi_id' => $request->instansi_id,
            'role' => $request->role,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
