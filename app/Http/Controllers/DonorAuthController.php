<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DonorAuthController extends Controller
{
    public function showLogin()
    {
        return view('donor.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('donor')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('donor.step1');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('donor.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin_panel.donors,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $donor = Donor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('donor')->login($donor);

        return redirect()->route('donor.dashboard');
    }

    public function dashboard()
    {
        return view('donor.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('donor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('donor.login');
    }
}
