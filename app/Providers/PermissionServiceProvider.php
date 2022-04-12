<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Route;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->permission_slug, function ($user) use ($permission) {
                    if ($user->hasPermission($permission->permission_slug)) return Response::allow();
                    elseif ($permission->permission_slug == 'update_user' AND $user->id == Route::getCurrentRoute()->originalParameters()['id']) return Response::allow();
                    else return Response::deny('У вас должно быть разрешение <b>'.$permission->permission_name.'</b>');
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }
}
