<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use App\Models\DetailPatrolConfig;
use App\Models\PatrolActivity;
use App\Models\ReportPatrol;
use App\Models\ReportPatrolDetail;
use App\Models\UserGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
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
        $activity = PatrolActivity::with('user', 'patrolShift', 'company', 'reportPatrol');
        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $activity->where('id_company', \Auth::user()->id_company);
        }
        $activity->orderBy('created_at', 'desc');
        return DataTables::of($activity->get())->addIndexColumn()->make(true);
    }

    public function detail($id): Factory|View|Application
    {
        $activityPatrol = PatrolActivity::where('id_patrol_activity', $id);
        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $activityPatrol->where('id_company', \Auth::user()->id_company);
        }
        $activityPatrol = $activityPatrol->first();
        $reportPatrol = ReportPatrol::with( 'patrolShift', 'reportPatrolDetail')
            ->where('id_patrol_activity', $id);
        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $reportPatrol->where('id_company', \Auth::user()->id_company);
        }
        $reportPatrol = $reportPatrol->get();
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
