<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PatrolConfigHelper;
use App\Models\PatrolActivity;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property Authenticatable|null $user
 */
class PatrolController extends BaseApiController
{

    public function getPatrolConfig(Request $request): array|\Illuminate\Database\Eloquent\Collection|Collection
    {
//        return DetailPatrolConfig::whereIdCompany($this->user->id_company)
//            ->where('level','>',$this->user->area)
//            ->whereStatus(true)
//            ->get();
        return PatrolConfigHelper::getFlattenConfig($this->user->id_company, $this->user->area);
    }

    public function patrolActivity(Request $request): JsonResponse
    {
        $patrolScheduleShiftId = $request->post('patrol_schedule_shift_id');
        $inShift = $request->post('in_shift');
        $patrolDate = $request->post('patrol_date');
        $patrolStartTime = $request->post('patrol_start_time');
        $patrolEndTime = $request->post('patrol_end_time');
        $status = $request->post('status');

        $activity = new PatrolActivity();
        $activity->id_user = $this->user->id_user;
        $activity->id_company = $this->user->id_company;
        $activity->patrol_schedule_shift_id = $patrolScheduleShiftId;
        $activity->patrol_date = Carbon::createFromFormat('Y-m-d', $patrolDate);
        $activity->patrol_start_time = Carbon::createFromFormat('Y-m-d H:i:s', $patrolStartTime);
        if ($inShift) {
            $activity->in_shift = $inShift;
        }
        if ($patrolEndTime)
            $activity->patrol_end_time = Carbon::createFromFormat('Y-m-d H:i:s', $patrolEndTime);
        $activity->status = $status;

        if ($activity->save()) {
            $activity = $activity->refresh();
            return response()->json($activity);
        }
        return response()->json(['status' => 'error', 'message' => 'Failed to save patrol activity'], 502);
    }


    public function getPatrolActivity(Request $request): ?JsonResponse
    {
        $activity = PatrolActivity::whereIdCompany($this->user->id_company)
            ->whereIdUser($this->user->id_user)
            ->wherePatrolDate(Carbon::now())
            ->where('patrol_schedule_shift_id', $request->get('shiftId'))
            ->first();
        return response()->json($activity);
    }
}
