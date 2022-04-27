<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    public function main() {
        $items = array();


        
        return view('Journals/journals', compact('items'));
    }
}
