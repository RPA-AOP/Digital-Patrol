<?php

namespace App\Http\Controllers\templates\form_elements;

use App\Http\Controllers\Controller;

class FileUpload extends Controller
{
  public function index()
  {
    return view('content.form-elements.forms-file-upload');
  }
}
