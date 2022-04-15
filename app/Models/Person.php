<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

        protected $connection;

        protected $table = 'person';

        public function __construct()
        {
            $this->connection = env('CSM_CONN');
        }

        public function person($fio) {
            return Person::leftJoin('position', 'person.hash', '=', 'position.hash')->where('fio', $fio)->first();
        }
}
