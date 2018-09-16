<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogleProvider()
    {
        $parameters = ['access_type' => 'offline'];

        return Socialite::driver('google')->scopes(["https://www.googleapis.com/auth/drive"])->with($parameters)->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return void
     */
    public function handleProviderGoogleCallback()
    {
        $auth_user = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            [
                'email' => $auth_user->email
            ],
            [
                'refresh_token' => $auth_user->token,
                'name'  =>  $auth_user->name
            ]
        );

        Auth::login($user, true);
        return redirect()->to('/'); // Redirect to a secure page
    }

    public function logout(Request $request)
    {
        session('g_token', '');
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
