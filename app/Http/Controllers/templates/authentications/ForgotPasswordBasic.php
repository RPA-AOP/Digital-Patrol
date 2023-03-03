<?php

namespace App\Http\Controllers\templates\authentications;

use App\Http\Controllers\Controller;

class ForgotPasswordBasic extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-forgot-password-basic', ['pageConfigs' => $pageConfigs]);
  }
}
