<?php

namespace App\Http\Controllers\templates\dashboard;

use App\Http\Controllers\Controller;

class Ecommerce extends Controller
{
    public function index(){
      return view('content.dashboard.dashboards-ecommerce');
    }
}
