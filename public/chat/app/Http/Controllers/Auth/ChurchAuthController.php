<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Church;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class ChurchAuthController extends Controller
{

    protected $redirectTo = '/church/dashboard';
    public function __construct()
    {
      $this->middleware('guest')->except('logout');
    }

	/* Login Page */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('church.dashboard');
        } else {
            return view('church.auth.login');
        }
    }

    /* Auth login request */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // $user = User::where('email', $request->email)->first();
        // if($user && $user->u_type != 'CHR')
        // {
        //     Session::flash('message', 'These credentials do not match our records.'); 
        //     Session::flash('alert-class', 'alert-danger'); 
        //     return redirect()->back()->with('error', 'These credentials do not match our records.');
        // }

        // $user = User::where('email', $request->email)->first();
        // if(!$user)
        // {
        //     $pwd = Crypt::decryptString($church->password);
        // }
        if(auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->route('/');
        } else {
            Session::flash('message', 'These credentials do not match our records.'); 
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->back()->with('error', 'These credentials do not match our records.');
        }
    }

    /* Logout */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
