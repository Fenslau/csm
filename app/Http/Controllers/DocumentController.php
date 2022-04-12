<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function main() {
      $items = array();

      return view('document', compact('items'));
    }
}
