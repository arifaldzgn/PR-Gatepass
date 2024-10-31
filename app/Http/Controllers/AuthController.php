<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function index()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('badge_no', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/asd');
        } else {
            return redirect()->back()->withInput()->withErrors(['message' => 'Invalid credentials']);
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'badge_no' => 'required|min:3',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/menu');

        }

        return back()->with('loginError', 'Invalid credentials');


    }

    // Logout user
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // If password is not empty, validate password and confirmation
        if (!empty($request->password)) {
            $validatedData = $request->validate([
                'email' => 'required|email:dns',
                'password' => 'required|confirmed', // Requires a corresponding "password_confirmation" field in your form
            ]);
            // Update user password
            $user->password = Hash::make($validatedData['password']);
        } else {
            // Validate email only if password is empty
            $validatedData = $request->validate([
                'email' => 'required|email:dns'
            ]);
        }

        // Update user email
        $user->email = $validatedData['email'];

        // Save user data
        $user->save();

        // After updating the user's data, check if the password was updated
        if (!empty($request->password)) {
            // Password was updated
            return response()->json(['message' => 'Profile and password updated successfully.']);
        } else {
            // Only profile (email) was updated
            return response()->json(['message' => 'Profile updated successfully.']);
        }


    }
}
