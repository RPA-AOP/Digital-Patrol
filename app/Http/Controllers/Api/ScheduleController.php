<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatrolScheduleDetailConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScheduleController extends Controller
{
	public function getSchedules(Request $request)
	{
		$user = auth('sanctum')->user();

		return PatrolScheduleDetailConfig::whereIdUser($user->id_user)
			->whereBetween('patrol_date',
				array(Carbon::now()->toDateString(),
					Carbon::now()->add("day", 2)->toDateString()))
			->get();
	}
}
