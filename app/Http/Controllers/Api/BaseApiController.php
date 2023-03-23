<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

/**
 * @property Authenticatable|null $user
 */
class BaseApiController extends Controller
{

    public function __construct()
    {
        $this->user = auth('sanctum')->user();
    }
}
