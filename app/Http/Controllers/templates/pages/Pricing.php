<?php

namespace App\Http\Controllers\templates\pages;

use App\Http\Controllers\Controller;

class Pricing extends Controller
{
  public function index()
  {
    return view('content.pages.pages-pricing');
  }
}
