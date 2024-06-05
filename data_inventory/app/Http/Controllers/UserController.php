<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        try {
            User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('login')->with('success', 'Registration successful. Please login.');
        } catch (\Exception $e) {
            return redirect()->route('register')->with('error', 'Registration failed. Please try again.');
        }
    }

    public function showLoginForm()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user) {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                return redirect()->route('inventory.index');
            } else {
                return back()->withErrors(['password' => 'Invalid password.']);
            }
        } else {
            // Jika pengguna belum terdaftar, arahkan ke halaman pendaftaran
            return redirect()->route('register')->withInput($request->only('username'));
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
