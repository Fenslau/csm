<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewRoleRequest;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Permission;

class RoleController extends Controller
{

    public function new(NewRoleRequest $request) {
        $role = Role::Create($request->all());
        if ($role) return back()->with('success', 'Новая роль <b>'.$request->role_name.'</b> создана');
        else return back()->with('error', 'Не удалось создать роль');
    }

    public function del(Request $request) {
        $role = Role::find($request->name)->delete();
        if ($role) return response()->json( array('success' => true));
        else return response()->json( array('success' => false));
    }

    public function id($id) {
        $role = Role::find($id);
        $permissions_all = Permission::get();
        $users = $role->users()->orderBy('updated_at', 'desc')->paginate(25);
        return view('role-profile', compact('role', 'permissions_all', 'users'));
    }

    public function give_permissions($id, Request $request) {
        $role = Role::find($id);
        if ($role->givePermissions($request->slug)) return back()->with('success', 'Права роли <b>'.$role->role_name.'</b> обновлены');
        else return back()->with('error', 'Не удалось обновить права роли');
    }
}
