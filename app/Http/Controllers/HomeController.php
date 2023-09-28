<?php

namespace App\Http\Controllers;

use App\Helpers\DashboardHelper;
use App\Models\ReportPatrolDetail;
use App\Models\UserGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    public function index(): View|Factory|RedirectResponse|Application
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }


    public function dashboard(Request $request): Factory|View|Application
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $todayAbnormalObject = DashboardHelper::getCountAbnormal(1, now()->month, now()->year);
        $todayNormalObject = DashboardHelper::getCountNormal(1, now()->month, now()->year);
        $todayQuickAction = DashboardHelper::getCountQuickAction(1, now()->month, now()->year);
        $todayReportPIC = DashboardHelper::getCountReportPic(1, now()->month, now()->year);
        $totalObject = DashboardHelper::getCountObject();
//        dd($todayAbnormalObject, $todayNormalObject, $totalObject);
        $percentageToday = 0;
        if ($totalObject != 0) {
            $percentageToday = round((($todayAbnormalObject + $todayNormalObject) / $totalObject) * 100);
        }

        $data = [
            'today' => [
                'objectNormal' => $todayNormalObject,
                'objectAbnormal' => $todayAbnormalObject,
                'quickAction' => $todayQuickAction,
                'reportPic' => $todayReportPIC,
                'percentage' => $percentageToday,
            ],
            'totalPatrolReport' => [
                'abnormality' => DashboardHelper::getCountAbnormal(30, $month, $year),
                'quickAction' => DashboardHelper::getCountQuickAction(30, $month, $year),
                'normalObject' => DashboardHelper::getCountNormal(30, $month, $year),
                'reportPic' => DashboardHelper::getCountReportPic(30, $month, $year),
                'solvedAbnormal' => DashboardHelper::getCountQuickAction(30, $month, $year),
                'totalObject' => $totalObject
            ],
        ];
        return view('modules.dashboard', $data);
    }

    public function list(\Illuminate\Http\Request $request)
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
        if (\Auth::user()->id_user_group == UserGroup::SECURITY) {
            $activity->where('action_user', \Auth::user()->id_user);
        }
        return DataTables::of($activity->get())->addIndexColumn()->make(true);

    }

    public function chart(Request $request): JsonResponse
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $todayAbnormalObject = DashboardHelper::getCountAbnormal(1, now()->month, now()->year);
        $todayNormalObject = DashboardHelper::getCountNormal(1, now()->month, now()->year);
        $todayQuickAction = DashboardHelper::getCountQuickAction(1, now()->month, now()->year);
        $todayReportPIC = DashboardHelper::getCountReportPic(1, now()->month, now()->year);
        $totalObject = DashboardHelper::getCountObject();
        $percentageToday = 0;
        if ($totalObject != 0) {
            $percentageToday = round((($todayAbnormalObject + $todayNormalObject) / $totalObject) * 100);
        }

        $data = [
            'today' => [
                'objectNormal' => $todayNormalObject,
                'objectAbnormal' => $todayAbnormalObject,
                'quickAction' => $todayQuickAction,
                'reportPic' => $todayReportPIC,
                'percentage' => $percentageToday,
            ],
            'totalPatrolReport' => [
                'abnormality' => DashboardHelper::getCountAbnormal(30, $month, $year),
                'quickAction' => DashboardHelper::getCountQuickAction(30, $month, $year),
                'normalObject' => DashboardHelper::getCountNormal(30, $month, $year),
                'reportPic' => DashboardHelper::getCountReportPic(30, $month, $year),
                'solvedAbnormal' => DashboardHelper::getCountQuickAction(30, $month, $year),
                'totalObject' => $totalObject
            ],
            'chart' => DashboardHelper::getPatrolReportPerDate($month, $year)
        ];
        return response()->json($data);
    }

    function getAbnormalTimeseries(Request $request)
    {
        $data = DashboardHelper::getAbnormalTimeSeries(120);
        return response()->json($data);
    }
}
