<?php

namespace App\Http\Controllers;

use App\Models\DetailPatrolConfig;
use App\Models\ReportPatrolDetail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

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
        $dateStart = Carbon::today()->format('Y-m-d');
        $dateEnd = Carbon::today()->format('Y-m-d');
        if (date('Hi') < 600) {
            $dateStart = Carbon::today()->add("day", -1)->format('Y-m-d');;
        }

        $todayAbnormalObject = ReportPatrolDetail::whereIsNormal(false)
            ->whereBetween('created_at', [$dateStart, $dateEnd])
            ->count();

        $todayNormalObject = ReportPatrolDetail::whereIsNormal(true)
            ->whereBetween('created_at', [$dateStart, $dateEnd])
            ->count();

        $todayQuickAction = ReportPatrolDetail::whereQuickAction(true)
            ->whereBetween('created_at', [$dateStart, $dateEnd])
            ->count();

        $todayReportPIC = ReportPatrolDetail::whereReportGa(true)
            ->whereBetween('created_at', [$dateStart, $dateEnd])
            ->count();

        $totalObject = DetailPatrolConfig::whereLastLevel(true)
            ->whereStatus(true)
            ->count();

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
                'abnormality' => 0,
                'quickAction' => 0,
                'normalObject' => 0,
                'solvedAbnormal' => 0,
                'totalObject' => $totalObject
            ],
        ];
        return view('modules.dashboard', $data);
    }

}
