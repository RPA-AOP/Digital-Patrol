<?php

namespace App\Http\Controllers\templates\apps;

use App\Http\Controllers\Controller;

class InvoiceEdit extends Controller
{
  public function index()
  {
    return view('content.apps.app-invoice-edit');
  }
}
