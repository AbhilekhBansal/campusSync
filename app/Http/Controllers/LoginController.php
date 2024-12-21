<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        return view('content.authentications.login');
    }


    public function authenticate(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt login
        if (Auth::attempt($validated)) {
            $user = Auth::user();


            $response = isUserActive($user);
            if (isset($response['user'])) {
                Auth::setUser($response['user']);
                $user = Auth::user();
            }

            if ($response['status'] !== 1) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Your account is not active.']);
            }

            if (in_array($user->role, ['admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard')->with('status', 'Welcome back, ' . $user->name . '!');
            }

            if (in_array($user->role, ['student'])) {
                return redirect()->route('student.dashboard')->with('status', 'Welcome back, ' . $user->name . '!');
            }
            if (in_array($user->role, ['teacher'])) {
                return redirect()->route('teacher.dashboard')->with('status', 'Welcome back, ' . $user->name . '!');
            }

            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'You do not have admin access.']);
        }

        return redirect()->route('login')->withErrors(['email' => 'Invalid email or password'])->withInput();
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
