<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Permission;

class Makeadmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $admin = User::firstOrCreate([
          'login'     => 'admin'], [
          'email'     => 'admin@test.com',
          'password'  => bcrypt('admin'),
        ]);

        if (!$admin->employee) $admin->employee()->save(new Employee(['user_name' => 'Admin', 'user_surname' => 'Admin']));
        if (!$admin->roles->contains('role_name', 'Админ')) {
          $role = Role::where('role_name', 'Админ')->first();
          if ($role) $admin->roles()->attach($role->id);
          else $admin->roles()->save(new Role(['role_name' => 'Админ']));
        }

        $role = Role::where('role_name', 'Админ')->first();


        $permissions = [
          'create_user'   => 'Создавать пользователей',
          'update_user'   => 'Обновление информации о пользователе',
          'create_role'   => 'Управление ролями',
          'permissions'   => 'Управление правами',
          'create_otkaz'  => 'Создавать отказ',
          'reason_add'    => 'Добавлять причины отказов',
          'reason_del'    => 'Удалять причины отказов',
          'otkaz_cost'   => 'Задавать стоимость отказов',
          'otkaz_stat'    => 'Смотреть статистику отказов',
        ];
        foreach ($permissions as $permission_slug => $permission_name) {
          $permission = Permission::firstOrCreate(['permission_slug' => $permission_slug], ['permission_name' => $permission_name]);
          if (!$role->permissions->contains('permission_slug', $permission_slug)) $role->permissions()->attach($permission->id);
        }

    }
}
