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
    $activity = ReportPatrolDetail::with('company', 'reportPatrol', 'object','objectParent')
      ->whereIsNormal(false)->get();
    return DataTables::of($activity)->addIndexColumn()->make(true);

  }

  public function detail($id): Factory|View|Application
  {
    $activityPatrol = PatrolActivity::where('id_patrol_activity', $id)->first();
    $reportPatrol = ReportPatrol::with('user', 'patrolShift', 'reportPatrolDetail')
      ->where('id_patrol_activity', $id)->get();
    return view('modules.report.patrolDetails', compact('reportPatrol', 'activityPatrol'));
  }

}
