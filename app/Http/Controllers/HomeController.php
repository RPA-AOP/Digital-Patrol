<?php

namespace App\Http\Controllers;

use App\Helpers\DashboardHelper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

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
}
