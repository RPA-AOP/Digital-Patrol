<?php

namespace App\Helpers;

use App\Models\DetailPatrolConfig;
use App\Models\PatrolActivity;
use App\Models\ReportPatrolDetail;
use App\Models\UserGroup;
use Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;


class DashboardHelper
{

    public static function getDateRange($interval)
    {
        $dateStart = Carbon::today()->format('Y-m-d h:m:s');
        $dateEnd = Carbon::today()->format('Y-m-d  h:m:s');
        if (date('Hi') < 600) {
            $dateStart = Carbon::today()->add("day", (-1 * $interval))->format('Y-m-d h:m:s');;
        }
        return [$dateStart, $dateEnd];
    }

    static function getCountAbnormal($interval): int
    {
        $dateRange = DashboardHelper::getDateRange($interval);
        $abnormalObject = ReportPatrolDetail::whereIsNormal(false)
            ->whereDateBetween('created_at', $dateRange[0], $dateRange[1]);

        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $abnormalObject->where('id_company', \Auth::user()->id_company);
        }
        return $abnormalObject->count();
    }

    static function getCountNormal($interval): int
    {
        $dateRange = DashboardHelper::getDateRange($interval);
        $normalObject = ReportPatrolDetail::whereIsNormal(true)
            ->whereDateBetween('created_at', $dateRange[0], $dateRange[1]);
        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $normalObject->where('id_company', \Auth::user()->id_company);
        }
        return $normalObject->count();
    }

    static function getCountQuickAction($interval): int
    {
        $dateRange = DashboardHelper::getDateRange($interval);
        $quickAction = ReportPatrolDetail::whereQuickAction(true)
            ->whereDateBetween('created_at', $dateRange[0], $dateRange[1]);
        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $quickAction->where('id_company', \Auth::user()->id_company);
        }

        return $quickAction->count();
    }

    static function getCountReportPic($interval): int
    {
        $dateRange = DashboardHelper::getDateRange($interval);
        $reportPIC = ReportPatrolDetail::whereReportGa(true)
            ->whereDateBetween('created_at', $dateRange[0], $dateRange[1]);
        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $reportPIC->where('id_company', \Auth::user()->id_company);
        }

        return $reportPIC->count();
    }

    static function getCountObject(): int
    {
        $totalObject = DetailPatrolConfig::whereLastLevel(true)
            ->whereStatus(true);
        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $totalObject->where('id_company', \Auth::user()->id_company);
        }
        return $totalObject->count();
    }

    static function getWeekDateArray()
    {
        $startWeek = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endWeek = Carbon::now()->endOfMonth()->format('Y-m-d');
        $period = CarbonPeriod::create($startWeek, $endWeek)->toArray();
        $result = [];
        foreach ($period as $date) {
            $result[] = $date->format('Y-m-d');
        }
        return $result;
    }

    static function getPatrolReportPerDate(): array
    {
        $data = PatrolActivity::join('report_patrol', 'patrol_activity.id_patrol_activity', 'report_patrol.id_patrol_activity')
            ->join('report_patrol_detail', 'report_patrol_detail.id_report_patrol', 'report_patrol.id_report_patrol')
            ->select([
                'patrol_date',
                \DB::raw('count(1) filter ( where report_patrol_detail.is_normal = true ) as normal'),
                \DB::raw('count(1) filter ( where report_patrol_detail.is_normal = false ) as abnormal'),
                \DB::raw('count(1) filter ( where report_patrol_detail.quick_action = true ) as quick_action'),
                \DB::raw('count(1) filter ( where report_patrol_detail.report_ga = true ) as report_pic'),
                \DB::raw('count(1) as total')
            ])
            ->groupBy('patrol_activity.patrol_date')
            ->get()
            ->toArray();

        $dataReport = [];
        $result = [
            'series' => [
//                [
//                    'name' => 'Total Objek Patroli',
//                    'data' => []
//                ],
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
            $dataReport[$datum['patrol_date']] = \Arr::except($datum, ['patrol_date']);
        }

        $datesWeek = self::getWeekDateArray();
        foreach ($datesWeek as $key => $date) {
//            $result['series'][0]['data'][$key] = \Arr::exists($dataReport, $date) ? $dataReport[$date]['total'] : 0;
            $result['series'][0]['data'][$key] = \Arr::exists($dataReport, $date) ? $dataReport[$date]['abnormal'] : 0;
            $result['series'][1]['data'][$key] = \Arr::exists($dataReport, $date) ? $dataReport[$date]['normal'] : 0;
            $date =  Carbon::createFromFormat('Y-m-d',$date);
            $result['label'][] = $date->format('j');
        }


        return $result;
    }
}
