<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create()
    {

        return inertia('AuthPractice/Login');
    }
    
    public function store(Request $request)
    {
        if(!Auth::attempt($request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
            // attempt work with key 'email', 'password' in table user
            // Its always check the password -> have to have 'password'
            // 'email' can be change for username,.. 
            // but in database table user have to have that column
        ]), true)){
            throw ValidationException::withMessages([
                'email' => 'Authentication failed'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/listing')
                    ->with('success', 'Login Success');
    }
    
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('listing.index')
                    ->with('success', 'Logout Success');
    }
}
