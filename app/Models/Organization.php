<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $connection;

    protected $table = 'position';

    public function __construct()
    {
        $this->connection = env('CSM_CONN');
    }


}
