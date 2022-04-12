<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use App\Http\Requests\NewUserRequest;
use App\Http\Requests\UserUpdateRequest;


class UserController extends Controller
{
    public function main() {
      $roles = Role::orderBy('updated_at', 'desc')->get();
      $users = Employee::with('user')->orderBy('updated_at', 'desc')->paginate(25);
      return view('users', compact('users', 'roles'));
    }

    public function id($id, Request $request) {
      $user = User::find($id);
      $roles_all = Role::get();
      return view('user-profile', compact('user', 'roles_all'));
    }

    public function new(NewUserRequest $request) {
      $login = ($request->login) ? $request->login : $login = Str::random(6);
      $password = ($request->password) ? $request->password : $password = Str::random(6);
      $user = User::Create([
        'login'     => $login,
        'email'     => $request->email,
        'password'  => bcrypt($password),
      ]);
      if ($user) $user->employee()->save(new Employee(['user_name' => $request->user_name, 'user_surname' => $request->user_surname]));

      if ($user->employee)
        return back()->with('success', 'Создан новый пользователь: <b>'.$request->user_name.' '.$request->user_surname.'</b> Логин: <b>'.$login.'</b> Пароль: <b>'.$password.'</b>');
      else back()->with('error', 'Не удалось создать пользователя');
    }

    public function give_roles($id, Request $request) {
        $user = User::find($id);
        if ($user->giveRoles($request->ids)) return back()->with('success', 'Роли пользователя <b>'.$user->employee->user_name.' '.$user->employee->user_surname.'</b> обновлены');
        else return back()->with('error', 'Не удалось обновить роли пользователя');
    }

    public function search(Request $request) {
        $users = Employee::with('user')->where('user_name', 'like', "%$request->search%")->orWhere('user_surname', 'like', "%$request->search%")->orderBy('updated_at', 'desc')->paginate(21);
        $returnHTML = view('inc.user-search-result', compact('users'))->render();
        return response()->json( array('success' => true, 'html'=>$returnHTML));
    }

    public function update($id, UserUpdateRequest $request) {
        $user = User::find($id);
        if ($request->password) $password = bcrypt($request->password); else $password = $user->password;
        if ($request->login) $login = $request->login; else $login = $user->login;
        if ($request->email) $email = $request->email; else $email = $user->email;
        $update = [
          'login'     => $login,
          'password'  => $password,
          'email'     => $email
        ];
        if ($user->update($update)) return back()->with('success', 'Профиль пользователя <b>'.$user->employee->user_name.' '.$user->employee->user_surname.'</b> обновлён');
        else return back()->with('error', 'Не удалось обновить профиль пользователя');
    }
}
