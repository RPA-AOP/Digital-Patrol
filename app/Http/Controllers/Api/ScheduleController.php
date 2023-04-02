<?php

namespace App\Http\Controllers\Api;

use App\Models\PatrolScheduleDetailConfig;
use App\Models\PatrolScheduleShift;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property Authenticatable|null $user
 */
class ScheduleController extends BaseApiController
{
    public function getSchedules(Request $request): array|\Illuminate\Database\Eloquent\Collection|Collection
    {
        $schedules = PatrolScheduleDetailConfig::whereIdUser($this->user->id_user)
            ->whereBetween('patrol_date',
                array(Carbon::now()->toDateString(),
                    Carbon::now()->add("day", 2)
                        ->toDateString()))
            ->join('patrol_schedule_shift as pss',
                'pss.patrol_schedule_shift_id',
                '=',
                'patrol_schedule_detail.patrol_schedule_shift_id')
            ->select([
                'patrol_schedule_detail.*',
                'pss.shift_name',
                'start_hour',
                'end_hour'])
            ->where("pss.shift_name", '!=', "LIBUR")
            ->orderBy('patrol_date')
            ->get();

        foreach ($schedules as $shift) {
            $dateEnd = $shift->patrol_date;
            if (Carbon::createFromFormat('H:i:s', $shift->start_hour)->gt(Carbon::createFromFormat('H:i:s', $shift->end_hour))) {
                $dateEnd = Carbon::parse($shift->patrol_date)->add("day", 1)->format('Y-m-d');
            }
            $shift->start_hour = Carbon::parse($shift->patrol_date . " " . $shift->start_hour)->format('Y-m-d H:i:s');;
            $shift->end_hour = Carbon::parse($dateEnd . " " . $shift->end_hour)->format('Y-m-d H:i:s');
        }

        return $schedules;
    }

    public function getShift(): array|\Illuminate\Database\Eloquent\Collection
    {
        $shifts = PatrolScheduleShift::whereArea($this->user->area)
            ->whereIdCompany($this->user->id_company)
            ->get();

        $dateStart = Carbon::now()->format('Y-m-d');
        $dateEnd = Carbon::now()->format('Y-m-d');
        if (date('Hi') < 600) {
            $dateStart = Carbon::now()->add("day", -1)->format('Y-m-d');
            $dateEnd = Carbon::now()->add("day", -1)->format('Y-m-d');
        }
        foreach ($shifts as $shift) {
            if (Carbon::parse($shift->start_hour)->gt(Carbon::parse($shift->end_hour))) {
                $dateEnd = Carbon::parse($dateEnd)->add("day", 1)->format('Y-m-d');
            }

            $shift->start_hour = Carbon::parse($dateStart . " " . $shift->start_hour)->format('Y-m-d H:i:s');;
            $shift->end_hour = Carbon::parse($dateEnd . " " . $shift->end_hour)->format('Y-m-d H:i:s');
        }
        return $shifts;
    }

}
