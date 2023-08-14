<?php

namespace App\Console\Commands;

use App\Models\DetailPatrolConfig;
use App\Models\PatrolActivity;
use App\Models\PatrolScheduleConfig;
use App\Models\PatrolScheduleDetailConfig;
use App\Models\PatrolScheduleShift;
use App\Models\ReportPatrol;
use App\Models\ReportPatrolDetail;
use App\Models\Users;
use Faker\Core\Uuid;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Rfc4122\UuidV3;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Symfony\Component\Console\Command\Command as CommandAlias;

class dummyPatrolSeeders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dummy:patrol
                            {id_company : id company}
                            {month : number of month}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to create dummy data patrol';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $idCompany = $this->argument('id_company');
        $month = $this->argument('month');

        $month = now()->year . '-' . $month;

        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        $dates = [];
        while ($start->lte($end)) {
            $dates[] = $start->copy();
            $start->addDay();
        }

        $users = Users::whereIdCompany($idCompany)->whereStatus(true)->get();
        $checkpoints = DetailPatrolConfig::whereIdCompany($idCompany)->whereLevel(4)->whereStatus(true)->with('child')->get();
        $patrolShift = PatrolScheduleShift::whereIdCompany($idCompany)->whereStatus(true)->where('shift_name','!=', 'LIBUR')->get();
        $patrolScheduleConfig = PatrolScheduleConfig::whereIdCompany($idCompany)->whereStatus(true)->first();
        foreach ($dates as $date) {
            $patrolDate = $date->format('Y-m-d');
            foreach ($patrolShift as $shift) {
                foreach ($users as $user) {
                    $patrolScheduleDetailConfig = PatrolScheduleDetailConfig::wherePatrolScheduleId($patrolScheduleConfig->patrol_schedule_id)
                        ->wherePatrolScheduleShiftId($shift->patrol_schedule_shift_id)
                        ->whereIdUser($user->id_user)
                        ->wherePatrolDate($patrolDate)
                        ->first();
                    if ($patrolScheduleDetailConfig){
                        $this->info("ASSIGN PATROL DATA ===> PATROL_DATE({$date->format('Y-m-d')}), USER_ID({$user->id_user}), SHIFT_ID({$shift->patrol_schedule_shift_id}), SCHEDULE_ID({$patrolScheduleConfig->patrol_schedule_id})");
                        $shiftStart = $shift->start_hour;
                        $shiftEnd = $shift->end_hour;
                        $startAt = Carbon::parse($patrolDate.' '.$shiftStart)->add('minute',rand(1,59));
                        $this->info($startAt);
                        $patrolActivity = PatrolActivity::create([
                            'id_company'=>$idCompany,
                            'id_user'=>$user->id_user,
                            'patrol_schedule_shift_id'=>$shift->patrol_schedule_shift_id,
                            'in_shift'=>true,
                            'patrol_date'=>$patrolDate,
                            'patrol_start_time'=>$startAt,
                            'status'=>1,
                            'created_at'=>$startAt,
                            'updated_at'=>$startAt
                        ]);
                        $startPatrolAt = $startAt;
                        $reportAt = $startPatrolAt;
                        $endPatrolAt = $reportAt;

                        foreach ($checkpoints as $checkpoint) {
                            $startPatrolAt = $startAt->add('minute', rand(1,5));
                            $syncToken=UuidV4::uuid4();

                            $reportPatrol = ReportPatrol::create([
                                'area_id'=>$checkpoint->id_detail_patrol_config,
                                'id_company'=>$idCompany,
                                'id_patrol_activity'=>$patrolActivity->id_patrol_activity,
                                'patrol_schedule_shift_id'=>$shift->patrol_schedule_shift_id,
                                'checkin_time'=>$startPatrolAt,
                                'status'=>true,
                                'sync_token'=>$syncToken
                            ]);
                            foreach ($checkpoint->child as $child) {
                                $reportAt = $startPatrolAt->add('second', rand(2,59));
                                $reportDetail = ReportPatrolDetail::create([
                                   'id_company'=>$idCompany,
                                   'id_report_patrol'=> $reportPatrol->id_report_patrol,
                                    'is_normal'=> true,
                                    'parent_level'=>$checkpoint->id_detail_patrol_config,
                                    'patrol_object_id'=>$child->id_detail_patrol_config,
                                    'sync_token'=>$syncToken,
                                    'created_at'=>$reportAt,
                                    'updated_at'=>$reportAt,
                                    'status'=>true

                                ]);
                            }
                            $endPatrolAt = $reportAt->add('minute', rand(1,5));
                            $reportPatrol->checkout_time = $reportAt->add('second', rand(10,25));
                            $reportPatrol->save();
                        }
                        $patrolActivity->patrol_end_time = $endPatrolAt->add('minute', rand(1,5));
                        $patrolActivity->save();
                    }
                }
            }
        }
        return CommandAlias::SUCCESS;
    }
}
