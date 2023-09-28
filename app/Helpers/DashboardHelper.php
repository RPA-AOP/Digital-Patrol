<?php

namespace App\Helpers;

use App\Models\DetailPatrolConfig;
use App\Models\PatrolActivity;
use App\Models\ReportPatrolDetail;
use App\Models\UserGroup;
use Arr;
use Auth;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;


class DashboardHelper
{

    public static function getDateRange($interval, $month, $year, $date = 1): array
    {
        if ($interval == 1) {
            $dateStart = Carbon::today()->format('Y-m-d h:m:s');
            $dateEnd = Carbon::today()->format('Y-m-d h:m:s');
            if (date('Hi') < 600) {
                $dateStart = Carbon::today()->add("day", (-1 * $interval))->format('Y-m-d h:m:s');
            }
        } else {
            $dateStart = Carbon::parse("{$year}-{$month}-{$date}")->format('Y-m-d h:m:s');
            $dateEnd = Carbon::parse("{$year}-{$month}")->add("day", (-1 * $interval))->format('Y-m-d h:m:s');
        }

        return [$dateStart, $dateEnd];
    }

    static function getDateInMonth($month, $year)
    {
        $startWeek = Carbon::parse("{$year}-{$month}")->startOfMonth()->format('Y-m-d');
        $endWeek = Carbon::parse("{$year}-{$month}")->endOfMonth()->format('Y-m-d');
        $period = CarbonPeriod::create($startWeek, $endWeek)->toArray();
        $result = [];
        foreach ($period as $date) {
            $result[] = $date->format('Y-m-d');
        }
        return $result;
    }

    static function getDateList($from, $to, $format = 'Y-m-d')
    {
        $period = CarbonPeriod::create($from, $to)->toArray();
        $result = [];
        foreach ($period as $date) {
            $result[] = $date->format($format);
        }
        return $result;
    }

    static function getCountAbnormal($interval, $month, $year): int
    {
        $dateRange = DashboardHelper::getDateRange($interval, $month, $year);
        $abnormalObject = ReportPatrolDetail::whereIsNormal(false)
            ->whereDateBetween('created_at', $dateRange[0], $dateRange[1]);

        if (in_array(Auth::user()->id_user_group, [UserGroup::ADMIN_COMPANY, UserGroup::PIC_GA])) {
            $abnormalObject->where('id_company', Auth::user()->id_company);
        }
        if (Auth::user()->id_user_group == UserGroup::SECURITY) {
            $abnormalObject->where('action_user', Auth::user()->id_user);
        }
        return $abnormalObject->count();
    }

    static function getAbnormalTimeSeries($interval): Collection|array
    {
        $dateRange = DashboardHelper::getDateRange($interval, now()->month, now()->year, now()->day);
        $abnormalObject = ReportPatrolDetail::whereIsNormal(false)
            ->whereDateBetween('created_at', $dateRange[1], $dateRange[0])
            ->select(
                [
                    DB::raw('count(id_report_patrol_detail) as count'),
                    DB::raw(' date(created_at) as date'),
                ]
            );

        if (in_array(Auth::user()->id_user_group, [UserGroup::ADMIN_COMPANY, UserGroup::PIC_GA])) {
            $abnormalObject->where('id_company', Auth::user()->id_company);
        }
        if (Auth::user()->id_user_group == UserGroup::SECURITY) {
            $userActivity = PatrolActivity::whereIdUser(Auth::user()->id_user)->select('id_patrol_activity')->pluck('id_patrol_activity')->toArray();
            $abnormalObject->whereIsNormal(false)
                ->whereHas('reportPatrol', function (Builder $query) use ($userActivity) {
                    $query->whereIn('id_patrol_activity', $userActivity);
                })->get();
        }
        $data = $abnormalObject->groupBy(['date'])->get()->toArray();
//        $data = $abnormalObject->get()->toArray();
        if (count($data)==0)
            return [];
        $dataAbnormal = [];
        foreach ($data as $d) {
            $dataAbnormal[$d['date']] = Arr::except($d, ['date']);
        }
        $dates = self::getDateList(Carbon::parse($data[0]['date'])->format('Y-m-d'), now()->format('Y-m-d'));
        $result = [];
        foreach ($dates as $key => $date) {
            $value = 0;
            if (Arr::has($dataAbnormal, $date))
                $value = $dataAbnormal[$date]['count'];
            $result[$key] =  [
                $date,
                $value
            ];
        }

        return $result;
    }

    static function getCountAbnormalByUser($idUser): int
    {
        $userActivity = PatrolActivity::whereIdUser($idUser)->select('id_patrol_activity')->pluck('id_patrol_activity')->toArray();
        $abnormalObject = ReportPatrolDetail::whereIsNormal(false)
            ->whereHas('reportPatrol', function (Builder $query) use ($userActivity) {
                $query->whereIn('id_patrol_activity', $userActivity);
            })->get();
        return $abnormalObject->count();
    }

    static function getAveragePercentageByUser($idUser, $idCompany): float
    {
        $userActivity = PatrolActivity::whereIdUser($idUser)
            ->select('id_patrol_activity')
            ->pluck('id_patrol_activity')
            ->toArray();
        if (count($userActivity) <= 0) {
            return 0;
        }
        $totalUserPatrolObject = ReportPatrolDetail::whereHas('reportPatrol',
            function (Builder $query) use ($userActivity) {
                $query->whereIn('id_patrol_activity', $userActivity);
            })
            ->count();

        $targetObject = DetailPatrolConfig::whereIdCompany($idCompany)
            ->whereLastLevel(true)
            ->whereStatus(true)
            ->count();
        $totalObjectTarget = $targetObject * count($userActivity);
        return round((($totalUserPatrolObject / $totalObjectTarget) * 100), 2);
    }

    static function getCountPatrolByUser($idUser): int
    {
        $abnormalObject = PatrolActivity::whereIdUser($idUser);
        return $abnormalObject->count();
    }

    static function getCountNormal($interval, $month, $year): int
    {
        $dateRange = DashboardHelper::getDateRange($interval, $month, $year);
        $normalObject = ReportPatrolDetail::whereIsNormal(true)
            ->whereDateBetween('created_at', $dateRange[0], $dateRange[1]);
        if (Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $normalObject->where('id_company', Auth::user()->id_company);
        }
        return $normalObject->count();
    }

    static function getCountQuickAction($interval, $month, $year): int
    {
        $dateRange = DashboardHelper::getDateRange($interval, $month, $year);
        $quickAction = ReportPatrolDetail::whereQuickAction(true)
            ->whereDateBetween('created_at', $dateRange[0], $dateRange[1]);
        if (Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $quickAction->where('id_company', Auth::user()->id_company);
        }

        return $quickAction->count();
    }

    static function getCountReportPic($interval, $month, $year): int
    {
        $dateRange = DashboardHelper::getDateRange($interval, $month, $year);
        $reportPIC = ReportPatrolDetail::whereReportGa(true)
            ->whereDateBetween('created_at', $dateRange[0], $dateRange[1]);
        if (Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $reportPIC->where('id_company', Auth::user()->id_company);
        }

        return $reportPIC->count();
    }

    static function getCountObject(): int
    {
        $totalObject = DetailPatrolConfig::whereLastLevel(true)
            ->whereStatus(true);
        if (Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $totalObject->where('id_company', Auth::user()->id_company);
        }
        return $totalObject->count();
    }


    static function getPatrolReportPerDate($month, $year): array
    {
        $data = PatrolActivity::join('report_patrol', 'patrol_activity.id_patrol_activity', 'report_patrol.id_patrol_activity')
            ->join('report_patrol_detail', 'report_patrol_detail.id_report_patrol', 'report_patrol.id_report_patrol')
            ->select([
                'patrol_date',
                DB::raw('count(1) filter ( where report_patrol_detail.is_normal = true ) as normal'),
                DB::raw('count(1) filter ( where report_patrol_detail.is_normal = false ) as abnormal'),
                DB::raw('count(1) filter ( where report_patrol_detail.quick_action = true ) as quick_action'),
                DB::raw('count(1) filter ( where report_patrol_detail.report_ga = true ) as report_pic'),
                DB::raw('count(1) as total')
            ])
            ->whereMonth('patrol_date', $month)
            ->whereYear('patrol_date', $year)
            ->groupBy('patrol_activity.patrol_date');


        if (Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $data->where('patrol_activity.id_company', Auth::user()->id_company);
        }
        $data = $data->get()->toArray();
        $dataReport = [];
        $result = [
            'series' => [
                [
                    'name' => 'Total Objek Abnormal',
                    'data' => []
                ],
                [
                    'name' => 'Total Objek Normal',
                    'data' => []
                ],
            ]
        ];
        foreach ($data as $datum) {
            $dataReport[$datum['patrol_date']] = Arr::except($datum, ['patrol_date']);
        }

        $dates = self::getDateInMonth($month, $year);
        foreach ($dates as $key => $date) {
//            $result['series'][0]['data'][$key] = \Arr::exists($dataReport, $date) ? $dataReport[$date]['total'] : 0;
            $result['series'][0]['data'][$key] = Arr::exists($dataReport, $date) ? $dataReport[$date]['abnormal'] : 0;
            $result['series'][1]['data'][$key] = Arr::exists($dataReport, $date) ? $dataReport[$date]['normal'] : 0;
            $date = Carbon::createFromFormat('Y-m-d', $date);
            $result['label'][] = $date->format('j');
        }

        return $result;
    }
}
