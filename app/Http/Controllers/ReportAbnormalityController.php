<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use App\Helpers\UploadFile;
use App\Models\PatrolActivity;
use App\Models\ReportPatrol;
use App\Models\ReportPatrolDetail;
use App\Models\UserGroup;
use Carbon\Carbon;
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
        $type = $request->get('type', 'abnormal');
        $activity = ReportPatrolDetail::with(['company:id_company,company_name',
            'reportPatrol.activity.user:id_user,name',
            'reportPatrol.activity:id_patrol_activity,id_user',
            'reportPatrol:id_report_patrol,id_patrol_activity',
            'object:id_detail_patrol_config,name',
            'action_user',
            'files',
            ]);
        switch ($type) {
            case 'abnormal':
                $activity = $activity->whereIsNormal(false)->whereActionStatus(false)->whereQuickAction(false);
                break;
            case 'action':
                $activity = $activity->whereIsNormal(false)->where(function ($query){
                    $query->whereActionStatus(true)->orWhere('quick_action', true);
                });
                break;
        }
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

    public function action(Request $request)
    {

        $idPatrolDetail = $request->id_report_patrol_detail;
        $patrolDetail = ReportPatrolDetail::find($idPatrolDetail);
        if ($patrolDetail) {
            $fileProof = $request->action_proof;
            $filePath = UploadFile::uploadSingle($fileProof, 'abnormal-action');
            $patrolDetail->action_status = true;
            $patrolDetail->action_note = $request->action_note;
            $patrolDetail->action_user = auth()->user()->id_user;
            $patrolDetail->action_at = Carbon::createFromFormat('d-m-Y H:i', $request->action_at);
            $patrolDetail->action_proof = $filePath;
            $patrolDetail->save();
            return redirect()->route('report.abnormal.index');
        }

        return redirect()->back(501)->with('error', 'update tindakan gagal, ');
    }
}
