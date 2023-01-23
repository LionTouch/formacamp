<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();


        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        Cookie::queue(Cookie::forget('user'));
        return redirect('/');
    }

    public function facebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function google(){
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookRedirect(){
        $user = Socialite::driver('facebook')->user();
        dd($user);
    }
    public function googleRedirect(){
        $user = Socialite::driver('facebook')->user();
        dd($user);
    }

    public function auth_check(Request $request)
    {
        return response()->json(['auth_check' =>\Auth::check()]);
    }
}
