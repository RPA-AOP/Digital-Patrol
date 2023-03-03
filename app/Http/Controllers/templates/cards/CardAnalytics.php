<?php

namespace App\Http\Controllers\templates\cards;

use App\Http\Controllers\Controller;

class CardAnalytics extends Controller
{
  public function index()
  {
    return view('content.cards.cards-analytics');
  }
}
