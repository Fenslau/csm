<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\NewUserRequest;
use App\Http\Requests\UserUpdateRequest;


class UserController extends Controller
{
    public function main() {
      $roles = Role::orderBy('updated_at', 'desc')->get();
      $users = User::orderBy('updated_at', 'desc')->paginate(25);
      return view('users', compact('users', 'roles'));
    }

    public function id($id, Request $request) {
      $user = User::find($id);
      $roles_all = Role::get();
      return view('user-profile', compact('user', 'roles_all'));
    }

    public function give_roles($id, Request $request) {
        $user = User::find($id);
        if ($user->giveRoles($request->ids)) return back()->with('success', 'Роли пользователя <b>'.$user->name.'</b> обновлены');
        else return back()->with('error', 'Не удалось обновить роли пользователя');
    }

    public function search(Request $request) {
        $users = User::where('name', 'like', "%$request->search%")->orderBy('updated_at', 'desc')->paginate(25);
        $returnHTML = view('inc.user-search-result', compact('users'))->render();
        return response()->json( array('success' => true, 'html'=>$returnHTML));
    }

}
