<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this functionality. Feel free to
    | explore this trait.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard'; // Atau rute dashboard Anda yang sebenarnya

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Anda bisa mengoverride method showResetForm jika ingin tampilan berbeda
    // public function showResetForm(Request $request, $token = null)
    // {
    //     return view('auth.passwords.reset')->with(
    //         ['token' => $token, 'email' => $request->email]
    //     );
    // }

    // Anda bisa mengoverride method reset jika ingin logika berbeda
    // protected function sendResetResponse(Request $request, $response)
    // {
    //     return redirect($this->redirectPath())->with('status', trans($response));
    // }

    // protected function sendResetFailedResponse(Request $request, $response)
    // {
    //     return back()->withInput($request->only('email'))
    //                 ->withErrors(['email' => trans($response)]);
    // }
}