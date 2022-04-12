<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    use HasFactory;

    protected $fillable = [
        'reason',
        'active'
    ];

    public function otkazy() {
      return $this->hasMany(Otkazy::class);
    }
}
