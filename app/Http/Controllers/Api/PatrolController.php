<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PatrolConfigHelper;
use App\Models\PatrolActivity;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Validator;

/**
 * @property Authenticatable|null $user
 */
class PatrolController extends BaseApiController
{

    public function getPatrolConfig(Request $request): array|\Illuminate\Database\Eloquent\Collection|Collection
    {
        return PatrolConfigHelper::getFlattenConfig($this->user->id_company, $this->user->area);
    }

    public function patrolActivity(Request $request): JsonResponse
    {
        $validate = Validator::make($request->all(),
            [
                'patrol_schedule_shift_id' => 'required|alpha_dash',
                'patrol_date' => 'alpha_dash',
                'patrol_start_time' => 'date',
                'patrol_end_time' => 'date',
                'status' => 'boolean|alpha_dash',
            ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }
        $patrolScheduleShiftId = $request->post('patrol_schedule_shift_id');
        $inShift = $request->post('is_shift');
        $patrolDate = $request->post('patrol_date');
        $patrolStartTime = $request->post('patrol_start_time');
        $patrolEndTime = $request->post('patrol_end_time',);
        $status = $request->post('status');
        $activity = PatrolActivity::updateOrCreate(
            [
                'id_user' => $this->user->id_user,
                'id_company' => $this->user->id_company,
                'patrol_schedule_shift_id' => $patrolScheduleShiftId,
                'patrol_date' => Carbon::createFromFormat('Y-m-d', $patrolDate),
                'in_shift' => $inShift == 'true',
                'patrol_start_time' => Carbon::createFromFormat('Y-m-d H:i:s', $patrolStartTime),
            ],
            [
                'status' => $status,
                'patrol_end_time' => $request->has('patrol_end_time') ? Carbon::createFromFormat('Y-m-d H:i:s', $patrolEndTime) : null
            ]
        );
        $activity->refresh();

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
            ->latest('created_at')
            ->first();
        return response()->json($activity);
    }
}
