<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateAdminPasswordRequest;
use App\Http\Requests\UpdateAdminProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            if (! $request->user()->is_admin) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'This account does not have admin access.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The email or password is incorrect.',
        ])->onlyInput('email');
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function updateProfile(UpdateAdminProfileRequest $request): RedirectResponse
    {
        $request->user()->update([
            'name' => $request->validated('name'),
        ]);

        return redirect()->back()->with('success', 'The admin username has been updated successfully!');
    }

    public function updatePassword(UpdateAdminPasswordRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return redirect()->back()->with('success', 'The admin password has been updated successfully!');
    }
}
