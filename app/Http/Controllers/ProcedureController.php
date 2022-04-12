<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    public function main() {
      $items = array();

      return view('procedure', compact('items'));
    }
}
