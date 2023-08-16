<?php

namespace App\Http\Controllers;

use App\Models\Users;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('doNotCacheResponse');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $pageConfigs = ['myLayout' => 'blank'];
        return view('auth.login', ['pageConfigs' => $pageConfigs]);
    }

    public function doLogin(Request $request)
    {
        if ($request->username && $request->password) {
            $user = Users::where('username', $request->username)->where('status', 1)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    Session::put('id_user', $user->id_user);
                    Auth::login($user);
                    activity('login')
                        ->causedBy($user)
                        ->performedOn($user)
                        ->withProperties($user)
                        ->event('login')
                        ->log('login');
                    return redirect()->route('login');
                } else {
                    activity('login')
                        ->causedBy($user)
                        ->performedOn($user)
                        ->withProperties($user)
                        ->event('login_failed')
                        ->log('login credentials not match');
                    return redirect('/login')->with(['error' => 'Username / Password Salah!']);
                }
            } else {
                activity('login')
                    ->event('user_not_found')
                    ->withProperties($request->session())
                    ->log('user not found');
                return redirect()->route('login')->with(['error' => 'Username / Password Salah!']);
            }
        } else {
            return redirect()->route('login')->with(['error' => 'Mohon isi seluruh field terlebih dahulu']);
        }
    }

    public function logout(): Redirector|Application|RedirectResponse
    {
        activity('logout')
            ->withProperties(\auth()->user())
            ->event('logout')
            ->log('logout user');
        Session::flush();
        return redirect('/');
    }
}
