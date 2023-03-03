<?php

namespace App\Http\Controllers\templates\dashboard;

use App\Http\Controllers\Controller;

class Crm extends Controller
{
  public function index()
  {
    return view('content.dashboard.dashboards-crm');
  }
}
