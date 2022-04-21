<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Person;
use App\Models\User;
use Adldap\Adldap;


class LoginController extends Controller
{

    public function login(Request $request) {

        $credentials = $request->validate([
            'login' => ['required'],
            //'password' => ['required'],
        ]);
        $user = $this->auth($credentials);

        if ($user) {
          $person = new Person();
          $person = $person->person($user['name']);
          if (isset($person->email)) $user['email'] = $person->email;
          if (isset($person->city)) $user['city'] = $person->city;
          if (isset($person->org)) $user['organization'] = $person->org;
          if (isset($person->department)) $user['department'] = $person->department;
          Auth::loginUsingId(User::get_id($user), true);
          return redirect()->intended(url()->previous());
        }
        else return back()->with('error', 'Неправильный логин или пароль');
    }



    public function auth($credentials) {
        if (env('APP_ENV') == 'local') {
          $name = Person::where('email', $credentials['login'].'@0370.ru')->first();
          if (isset($name->fio)) return (['name' => $name->fio, 'email' => $name->email]);
          else return FALSE;
        }
        $config = array(
            'account_suffix' => env('AD_ACCOUNT_SUFFIX'),
            'domain_controllers' => array(env('AD_DOMAIN_CONTROLLERS')),
            'base_dn' => env('AD_BASE_DN'),
            'admin_username' => env('AD_ADMIN_USERNAME'),
            'admin_password' => env('AD_ADMIN_PASSWORD'),
        );
        $ad = new Adldap($config);
        if ($ad->authenticate($credentials['login'], $credentials['password'])) {
          $info = $ad->user()->info($credentials['login']);
          dd($info);
          $user['name'] = $info[0]['displayname'][0];
          $user['email'] = $info[0]['mail'][0];
          return $user;
        }
        return FALSE;
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
