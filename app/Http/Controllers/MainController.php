<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{

  public function main() {



    $items = array();
    return view('home', compact('items'));
  }

}
