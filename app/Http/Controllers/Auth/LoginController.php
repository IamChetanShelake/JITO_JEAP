<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('auth')->only('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // Try web guard first
        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            return true;
        }

        // If web fails, try apex guard
        if (Auth::guard('apex')->attempt($credentials, $request->filled('remember'))) {
            // Log the apex user into web guard for middleware compatibility
            $user = Auth::guard('apex')->user();
            Auth::login($user);
            return true;
        }

        // If apex fails, try committee guard
        if (Auth::guard('committee')->attempt($credentials, $request->filled('remember'))) {
            // Log the committee user into web guard for middleware compatibility
            $user = Auth::guard('committee')->user();
            Auth::login($user);
            return true;
        }

        // If committee fails, try chapter guard
        if (Auth::guard('chapter')->attempt($credentials, $request->filled('remember'))) {
            // Log the chapter user into web guard for middleware compatibility
            $user = Auth::guard('chapter')->user();
            Auth::login($user);
            return true;
        }

        return false;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user && in_array($user->role, ['admin', 'apex', 'working-committee', 'chapter'])) {
            return redirect()->route('admin.home');
        } elseif ($user && $user->role === 'user') {
            return redirect()->route('user.home');
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $user = Auth::user() ?: Auth::guard('apex')->user();

        $response = $this->authenticated($request, $user);

        if ($response) {
            return $response;
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the current user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('apex')->logout();
        Auth::guard('committee')->logout();
        Auth::guard('chapter')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
