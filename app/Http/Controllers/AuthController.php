<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if 
        ($user && Hash::check($request->password, $user->password))
        //($user && $request->password === $user->password)
        {
            Auth::login($user);

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard')->with('success', 'Login Succeed as Admin!');
                case 'student':
                    return redirect()->route('student.dashboard')->with('success', 'Login Succeed as Peserta Magang!');
                case 'mentor':
                    return redirect()->route('mentor.dashboard')->with('success', 'Login Succeed as Mentor!');
                default:
                    return redirect()->route('login')->with('error', 'Invalid role!');
            }
        }
        else
        {
            return redirect()->route('login')->with('error', 'Wrong Email or password !');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
