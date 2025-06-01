<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset link emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Anda bisa mengoverride method showLinkRequestForm jika ingin tampilan berbeda
    // public function showLinkRequestForm()
    // {
    //     return view('auth.passwords.email');
    // }

    // Anda bisa mengoverride method sendResetLinkEmail jika ingin logika berbeda
    // protected function sendResetLinkResponse(Request $request, $response)
    // {
    //     return back()->with('status', trans($response));
    // }

    // protected function sendResetLinkFailedResponse(Request $request, $response)
    // {
    //     return back()->withErrors(['email' => trans($response)]);
    // }
}