<?php

namespace App\Http\Controllers\templates\user_interface;

use App\Http\Controllers\Controller;

class TabsPills extends Controller
{
  public function index()
  {
    return view('content.user-interface.ui-tabs-pills');
  }
}
