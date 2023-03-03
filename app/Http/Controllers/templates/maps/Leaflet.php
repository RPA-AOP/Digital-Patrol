<?php

namespace App\Http\Controllers\templates\maps;

use App\Http\Controllers\Controller;

class Leaflet extends Controller
{
  public function index()
  {
    return view('content.maps.maps-leaflet');
  }
}
