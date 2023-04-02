<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use App\Helpers\UploadFile;
use App\Imports\ImportPatrolConfig;
use App\Models\DetailPatrolConfig;
use App\Models\MasterCategory;
use App\Models\MasterCompany;
use App\Models\PatrolActivity;
use App\Models\PatrolConfig;
use App\Models\ReportPatrol;
use App\Models\ReportPatrolDetail;
use Complex\Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\DataTables\DataTables;

class ReportPatrolController extends Controller
{

    public function index(): View|Factory|Application
    {
        $permission = Permission::get();
        if ($permission->has_view) {
            $data = ['permission' => $permission];
            return view('modules.report.patrol', $data);
        } else {
            return abort(403, 'Anda tidak memiliki akses pada menu ini');
        }
    }

    public function list(Request $request)
    {
        $activity = PatrolActivity::with('user', 'patrolShift', 'company', 'reportPatrol')->get();
        return DataTables::of($activity)->addIndexColumn()->make(true);
    }

    public function detail($id): Factory|View|Application
    {
        $activityPatrol = PatrolActivity::where('id_patrol_activity', $id)->first();
        $reportPatrol = ReportPatrol::with('user', 'patrolShift', 'reportPatrolDetail')
            ->where('id_patrol_activity', $id)->get();
        $abnormalObject = ReportPatrolDetail::whereIsNormal(false)
            ->whereIn('id_report_patrol', $reportPatrol->pluck('id_report_patrol'))
            ->count();
        $normalObject = ReportPatrolDetail::whereIsNormal(true)
            ->whereIn('id_report_patrol', $reportPatrol->pluck('id_report_patrol'))
            ->count();
        $totalObject = DetailPatrolConfig::whereIdCompany($activityPatrol->id_company)
            ->whereLastLevel(true)
            ->whereStatus(true)->count();
        return view('modules.report.patrolDetails',
            compact(['reportPatrol',
                'activityPatrol',
                'abnormalObject',
                'normalObject',
                'totalObject']));
    }

    public function preview(Request $request): StreamedResponse
    {
        $filePath = $request->get('path');
        if (Storage::exists($filePath)) {
            return Storage::response($filePath);
        }
        return abort(404, "not found");
    }
}
