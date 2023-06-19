<?php

namespace App\Http\Controllers;

use App\Helpers\DashboardHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function index(): View|Factory|RedirectResponse|Application
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function dashboard(): Factory|View|Application
    {

        $todayAbnormalObject = DashboardHelper::getCountAbnormal(1);
        $todayNormalObject = DashboardHelper::getCountNormal(1);
        $todayQuickAction = DashboardHelper::getCountQuickAction(1);
        $todayReportPIC = DashboardHelper::getCountReportPic(1);
        $totalObject = DashboardHelper::getCountObject();
        $percentageToday = round((($todayAbnormalObject + $todayNormalObject) / $totalObject) * 100);

        $data = [
            'today' => [
                'objectNormal' => $todayNormalObject,
                'objectAbnormal' => $todayAbnormalObject,
                'quickAction' => $todayQuickAction,
                'reportPic' => $todayReportPIC,
                'percentage' => $percentageToday,
            ],
            'totalPatrolReport' => [
                'abnormality' => DashboardHelper::getCountAbnormal(30),
                'quickAction' => DashboardHelper::getCountQuickAction(30),
                'normalObject' => DashboardHelper::getCountNormal(30),
                'reportPic' => DashboardHelper::getCountReportPic(30),
                'solvedAbnormal' => DashboardHelper::getCountQuickAction(30),
                'totalObject' => $totalObject
            ],
        ];
        return view('modules.dashboard', $data);
    }

    public function chart(\Request $request): JsonResponse
    {

        $todayAbnormalObject = DashboardHelper::getCountAbnormal(1);
        $todayNormalObject = DashboardHelper::getCountNormal(1);
        $todayQuickAction = DashboardHelper::getCountQuickAction(1);
        $todayReportPIC = DashboardHelper::getCountReportPic(1);
        $totalObject = DashboardHelper::getCountObject();
        $percentageToday = round((($todayAbnormalObject + $todayNormalObject) / $totalObject) * 100);

        $data = [
            'today' => [
                'objectNormal' => $todayNormalObject,
                'objectAbnormal' => $todayAbnormalObject,
                'quickAction' => $todayQuickAction,
                'reportPic' => $todayReportPIC,
                'percentage' => $percentageToday,
            ],
            'totalPatrolReport' => [
                'abnormality' => DashboardHelper::getCountAbnormal(30),
                'quickAction' => DashboardHelper::getCountQuickAction(30),
                'normalObject' => DashboardHelper::getCountNormal(30),
                'reportPic' => DashboardHelper::getCountReportPic(30),
                'solvedAbnormal' => DashboardHelper::getCountQuickAction(30),
                'totalObject' => $totalObject
            ],
            'chart' => DashboardHelper::getPatrolReportPerDate()
        ];
        return response()->json($data);
    }
}
