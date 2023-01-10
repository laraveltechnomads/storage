<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if(auth()->check())
        {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);
        $credential = [
            'email' => $request->email, 
            'password' => $request->password
        ];  
        if (Auth::attempt($credential)) {
            return redirect()->route('admin.dashboard')->with('success', 'Admin Login succesfully');
        } else {
            return redirect()->back()->with('error', 'These credentials do not match our records.');
        }
    }
    public function logOut(){
        Auth::logout();
        return redirect()->route('login')->with('success', 'Admin logout successfully!.');
    }
}
