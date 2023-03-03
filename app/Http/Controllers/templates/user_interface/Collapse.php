<?php

namespace App\Http\Controllers\templates\user_interface;

use App\Http\Controllers\Controller;

class Collapse extends Controller
{
  public function index()
  {
    return view('content.user-interface.ui-collapse');
  }
}
