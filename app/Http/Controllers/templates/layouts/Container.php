<?php

namespace App\Http\Controllers\templates\layouts;

use App\Http\Controllers\Controller;

class Container extends Controller
{
  public function index()
  {
    return view('content.layouts-example.layouts-container');
  }
}
