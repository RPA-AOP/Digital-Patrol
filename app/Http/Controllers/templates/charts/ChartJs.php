<?php

namespace App\Http\Controllers\templates\charts;

use App\Http\Controllers\Controller;

class ChartJs extends Controller
{
  public function index()
  {
    return view('content.charts.charts-chartjs');
  }
}
