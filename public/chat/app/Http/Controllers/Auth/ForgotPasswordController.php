<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;


// use Illuminate\Notifications\Messages\MailMessage;
// use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Mail;

use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);
        $response = $this->broker();
        $user = User::where('email', $request->email)->first();
        if(!$user)
        {
            Session::flash('message', 'Invalid Email.'); 
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->back();
        }
        $otp = rand(6, 999999);
        $otp_time_out = strtotime("+2 minutes");
        Session::put('email_otp', $otp);
        Session::put('otp_time_out', $otp_time_out);
        Session::put('reset_email', $request->email);
        Mail::send('emails.verification', ['otp' => $otp, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        Session::flash('message', 'Otp sent to email. Please check email.'); 
        Session::flash('alert-class', 'alert-success'); 
        return redirect()->route('email.verification', ['email' => $request->email])->with('status', 'otp sent to email. please check email');



        // return $response == Password::RESET_LINK_SENT
                    // ? $this->sendResetLinkResponse($request, $response)
                    // : $this->sendResetLinkFailedResponse($request, $response);
    }

    public function resedOTP(Request $request){
        return $this->sendResetLinkEmail($request);
    }

    protected function validateEmail(Request $request)
    {
       return $request->validate(['email' => 'required|email']);
    }

    protected function credentials(Request $request)
    {
        return $request->only('email');
    }


    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $request->wantsJson()
                    ? new JsonResponse(['message' => trans($response)], 200)
                    : back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
    }

    public function broker()
    {
        return Password::broker();
    }

    public function showEmailVerification(Request $request)
    {
        $email = $request->email;
        return view('auth.verificationOTP', compact('email'));
    }

    public function checkOTPVerification(Request $request){
        $otp_time_out = Session::get('otp_time_out');
        $now = strtotime("now");
        if($now < $otp_time_out)
        {
            $email =$request->email;
            $otp =  Session::get('email_otp');
            $reset_email =  Session::get('reset_email');
            if($request->otp == $otp && $email == $reset_email)
            {
                Session::flash('message', 'Email verification done.'); 
                Session::flash('alert-class', 'alert-success'); 
                return redirect()->route('new.password.page', compact('email') );
            }
            Session::flash('message', 'Invalid OTP.'); 
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->back()->with('', 'Session expired');
        }
        Session::flash('message', 'Session expired.'); 
        Session::flash('alert-class', 'alert-danger'); 
        return redirect()->back()->with('', 'Session expired');
      
    }

    public function newPasswordPage(Request $request){
        $email = $request->email;
        return view('auth.passwords.reset', compact('email'));
    }

    public function newPasswordUpdate(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
        if(auth()->check() && auth()->user()->isAdmin() )
        {
            return redirect('/');
        }
        return redirect('login');
    }

    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    protected function validationErrorMessages()
    {
        return [];
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
