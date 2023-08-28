<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use App\Helpers\UploadFile;
use App\Imports\ImportPatrolScheduleConfig;
use App\Models\DetailPatrolConfig;
use App\Models\MasterCompany;
use App\Models\PatrolScheduleConfig;
use App\Models\PatrolScheduleDetailConfig;
use App\Models\PatrolScheduleShift;
use App\Models\UserGroup;
use App\Models\Users;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleConfigController extends Controller
{

    public function index(): View|Factory|Application|RedirectResponse
    {
        $permission = Permission::get();
        if ($permission->has_view) {
            $data = ['permission' => $permission];
            return \Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY ? redirect()->route('scheduleconfig.manage', ['id' => \Auth::user()->id_company]) : view('modules.schedule.index', $data);
        } else {
            abort(403, 'Anda tidak memiliki akses pada menu ini');
        }
    }

    public function list(Request $request): JsonResponse
    {
        $data = PatrolScheduleDetailConfig::
        join('patrol_schedule_shift as pss', 'pss.patrol_schedule_shift_id', 'patrol_schedule_detail.patrol_schedule_shift_id')
            ->join('users as u', 'u.id_user', 'patrol_schedule_detail.id_user')
            ->join('patrol_schedule as ps', 'ps.patrol_schedule_id', 'patrol_schedule_detail.patrol_schedule_id')
            ->where('ps.id_company', $request->idCompany)
            ->whereDate('patrol_date', '>=', $request->start)
            ->whereDate('patrol_date', '<=', $request->end)
            ->select(['patrol_schedule_detail as id', 'pss.shift_code', 'pss.patrol_schedule_shift_id as shift_id',
                DB::raw('CONCAT(pss.shift_name, \' \',u.name) as title'),
                'u.name as user',
                'pss.shift_name',
                'u.npk',
                'patrol_schedule_detail.patrol_date',
                'pss.start_hour',
                'pss.end_hour'
            ])
            ->get();
        $events = [];
        foreach ($data as $d) {
//            dd($d);
            $start = Carbon::parse($d->patrol_date . ' ' . $d->start_hour);
            $end = Carbon::parse($d->patrol_date . ' ' . $d->end_hour);
            if ($start->gte($end))
                $end->addDays(1);

            $event = [
                'id' => $d->id,
                'title' => $d->title,
                'start' => $start->format('Y-m-d H:i:s'),
                'end' => $end->format('Y-m-d H:i:s'),
                'allday' => false,
                'extendedProps' => [
                    'calendar' => $d->npk,
                    'shift_name' => $d->shift_name,
                    'shift_id' => $d->shift_id,
                    'user' => $d->user,
                ]
            ];
            if ($d->shift_code == "LIBUR") {
                $event['allday'] = true;
            }
            $events[] = $event;
        }

        return response()->json($events);
    }

    public function create(): Factory|View|Application
    {
        return view('modules.schedule.create');

    }

    public function manage($id): Factory|View|Application
    {
        $company = MasterCompany::where('id_company', $id)->first();
        $patrolUsersShift = Users::whereIdCompany($id)
            ->whereStatus(true)
            ->whereIdUserGroup(4)
            ->get();
        $patrolScheduleShift = PatrolScheduleShift::where('id_company', $id)->get();
        $area = DetailPatrolConfig::where('level', '<=', 2)
            ->whereStatus(true)
            ->whereIdCompany($id)
            ->orderBy('level')
            ->get();
        return view('modules.schedule.manage', compact(['company', 'patrolUsersShift', 'patrolScheduleShift', 'area']));

    }

    public function import(Request $request): RedirectResponse
    {
        $maxfilesize = config('app.max_file_size_upload') * 1024;
        $request->validate([
            'import-data_patroli' => "required|mimes:xlsx,xls|max:{$maxfilesize}"
        ]);

        $idCompany = $request->get('id_company');
        $area = $request->get('area');
        $patrolScheduleConfig = PatrolScheduleConfig::where('id_company', $idCompany)->first();
        $files = $request->file('import-data_patroli');
        if ($files) {
            if (!$patrolScheduleConfig) {
                $patrolScheduleConfig = PatrolScheduleConfig::create([
                    'id_company' => $idCompany,
                    'created_by' => Auth::user()->getAuthIdentifier(),
                    'status' => 1
                ]);
                $patrolScheduleConfig->save();
            }
            if ($patrolScheduleConfig) {
                $filePath = UploadFile::uploadSingle($files);
                if ($filePath) {
                    $month = $request->get('month');
                    $year = $request->get('year');

                    Excel::import(new ImportPatrolScheduleConfig($idCompany, $patrolScheduleConfig->patrol_schedule_id, $month, $year, $area), $filePath);
                    return redirect()->route('scheduleconfig.manage', $idCompany)->with('success', 'Import Success.');
                } else {
                    return redirect()->back(501)->with('error', 'upload failed, ');
                }
            }
        }
        return redirect()->back(501)->with('error', 'upload failed, ');

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $detailConfig = DetailPatrolConfig::where('id_detail_patrol_config', $id)->first();
        $detailConfig->code = $request->code;
        $detailConfig->name = $request->name;
        $detailConfig->identification_key = $request->identification_key;
        if ($request->post('category_id'))
            $detailConfig->category_id = $request->category_id;
        if ($detailConfig->save()) {
            $detailConfig->refresh();
            return response()->json(['status' => 'updated', 'data' => $detailConfig->toArray()], 200);

        }
        return response()->json(['status' => 'update failed',], 500);

    }

    function updateList($data, $idPatrolConfig, $parent_id = 0): bool
    {
        foreach ($data as $item) {
            try {
                $detailConfig = DetailPatrolConfig::where('id_detail_patrol_config', $item['id'])
                    ->where('id_patrol_config', $idPatrolConfig)->first();
                $detailConfig->parent_id = $parent_id;
                $detailConfig->save();
            } catch (Exception $e) {
                return false;
            }
            if (array_key_exists("children", $item)) {
                $this->updateList($item['children'], $idPatrolConfig, $item['id']);
            }
        }
        return true;
    }


    public function updateShift(Request $request, $companyId)
    {
        foreach ($request->shift as $key => $shift) {
            PatrolScheduleShift::where('id_company', $companyId)
                ->where('patrol_schedule_shift_id', $key)
                ->update([
                    'start_hour' => $shift['start_hour'],
                    'end_hour' => $shift['end_hour']
                ]);
        }
        return redirect()->route('scheduleconfig.manage', ['id' => $companyId]);

    }
}
