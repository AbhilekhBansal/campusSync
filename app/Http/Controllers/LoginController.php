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
        // Validate the input
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validate->fails()) {
            // Redirect back with validation errors
            return redirect()->back()->withInput()->withErrors($validate);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->withErrors(['email' => 'Invalid email or password'])->withInput();
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
