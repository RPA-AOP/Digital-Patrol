<?php

namespace Database\Seeders;

use App\Models\PatrolActivity;
use App\Models\PatrolConfig;
use App\Models\ReportPatrol;
use App\Models\ReportPatrolDetail;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReportPatrolSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $activityPatrol = PatrolActivity::create([
      'id_company' => 1,
      'patrol_schedule_shift_id' => 1,
      'id_user'=>2,
      'patrol_date'=>now()->format("Y-m-d"),
      'patrol_start_time'=>now(),
      'patrol_end_time'=>now()->add(1, 'hour')
    ]);
    $reportPatrol = ReportPatrol::create([
        'id_patrol_activity' => $activityPatrol->id_patrol_activity,
        'id_company' => 1,
        'patrol_schedule_shift_id' => 1,
        'level_1' => 1,
        'level_2' => 1,
        'level_3' => 1,
        'checkin_time' => Carbon::now(),
        'checkout_time' => Carbon::now()->add("minute", 10),
        'status' => true]
    );
//    $reportPatrol->id_report_patrol
    ReportPatrolDetail::create([
      'id_company' => 1,
      'id_report_patrol' => $reportPatrol->id_report_patrol,
      'parent_level' => 1,
      'patrol_object_id' => 1,
      'is_normal' => false,
      'patrol_note' => "ABNORMAL",
      'is_accident_report' => false,
      'report_ga' => false,
      'quick_action' => false,
      'quick_action_note' => "ABNORNAL"
    ]);

  }
}
