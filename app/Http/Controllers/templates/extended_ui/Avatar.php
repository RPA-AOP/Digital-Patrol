<?php

namespace App\Http\Controllers\templates\extended_ui;

use App\Http\Controllers\Controller;

class Avatar extends Controller
{
  public function index()
  {
    return view('content.extended-ui.extended-ui-avatar');
  }
}
