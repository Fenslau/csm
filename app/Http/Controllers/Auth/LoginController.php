<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Adldap\Adldap;

class LoginController extends Controller
{

    public function login(Request $request) {

        $credentials = $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);
        $config = array(
            'account_suffix' => "@csm.local",
            'domain_controllers' => array("192.168.1.59"),
            'base_dn' => 'DC=csm,DC=local',
            'admin_username' => '',
            'admin_password' => '',
        );
        $ad = new Adldap($config);
        if ($ad->authenticate($request->login, $request->password)) {
          dd($adldap->user()->info($request->login));
        }
        dd('Fail');

        if (Auth::attempt($credentials, $remember = true)) {
            $request->session()->regenerate();
            return redirect()->intended(url()->previous());
        }
        return back()->with('error', 'Неправильный логин или пароль');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
