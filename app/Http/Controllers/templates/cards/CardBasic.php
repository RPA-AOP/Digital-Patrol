<?php

namespace App\Http\Controllers\templates\cards;

use App\Http\Controllers\Controller;

class CardBasic extends Controller
{
  public function index()
  {
    return view('content.cards.cards-basic');
  }
}
