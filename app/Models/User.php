<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'city',
        'organization',
        'department',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // public function getAuthPassword() {
    //
    //   return bcrypt('123');
    // }

    public static function get_id($user) {
        User::updateOrCreate(['name' => $user['name']], $user);
        return User::where('name', $user['name'])->pluck('id');
    }

    public function otkazy() {
        return $this->hasMany(Otkazy::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasPermission($permission) {
        $permission = Permission::where('permission_slug', $permission)->first();
        foreach ($permission->roles as $role){
            if($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }


    public function giveRoles($ids) {
        if ($ids === NULL) {
          $this->roles()->detach();
          return TRUE;
        } else {
            $roles = Role::whereIn('id', $ids)->get();
            if($roles !== null) {
                $this->roles()->detach();
                $this->roles()->saveMany($roles);
                return TRUE;
            } else return FALSE;
        }
    }
}
