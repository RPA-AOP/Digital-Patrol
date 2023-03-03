<?php

namespace App\Http\Controllers\templates\pages;

use App\Http\Controllers\Controller;

class HelpCenterCategories extends Controller
{
  public function index()
  {
    return view('content.pages.pages-help-center-categories');
  }
}
