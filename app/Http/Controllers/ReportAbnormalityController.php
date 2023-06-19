<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use App\Models\PatrolActivity;
use App\Models\ReportPatrol;
use App\Models\ReportPatrolDetail;
use App\Models\UserGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportAbnormalityController extends Controller
{

    public function index(): View|Factory|Application
    {
        $permission = Permission::get();
        if ($permission->has_view) {
            $data = ['permission' => $permission];
            return view('modules.report.abnormal', $data);
        } else {
            return abort(403, 'Anda tidak memiliki akses pada menu ini');
        }
    }

    public function list(Request $request)
    {
        $activity = ReportPatrolDetail::with('company', 'reportPatrol', 'object', 'objectParent')
            ->whereIsNormal(false);
        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $activity->where('id_company', \Auth::user()->id_company);
        }
        return DataTables::of($activity->get())->addIndexColumn()->make(true);

    }

    public function detail($id): Factory|View|Application
    {
        $activityPatrol = PatrolActivity::where('id_patrol_activity', $id)->first();
        $reportPatrol = ReportPatrol::with('user', 'patrolShift', 'reportPatrolDetail')
            ->where('id_patrol_activity', $id)->get();
        return view('modules.report.patrolDetails', compact('reportPatrol', 'activityPatrol'));
    }

}
