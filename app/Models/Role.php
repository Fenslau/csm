<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name',
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function givePermissions($slugs) {
        if ($slugs === NULL) {
          $this->permissions()->detach();
          return TRUE;
        } else {
            $permissions = Permission::whereIn('permission_slug', $slugs)->get();
            if($permissions !== null) {
                $this->permissions()->detach();
                $this->permissions()->saveMany($permissions);
                return TRUE;
            } else return FALSE;
        }
    }
}
