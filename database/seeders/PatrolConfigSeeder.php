<?php

namespace Database\Seeders;

use App\Imports\ImportPatrolConfig;
use App\Imports\ImportPatrolScheduleConfig;
use App\Models\PatrolConfig;
use App\Models\PatrolScheduleConfig;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class PatrolConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $patrolConfig = PatrolConfig::create(['id_company'=>1, 'created_by'=>1, 'status'=>true]);
      $patrolScheduleConfig = PatrolScheduleConfig::create(['id_company'=>1, 'status'=>true]);

      Excel::import(new ImportPatrolConfig(1, $patrolConfig->id_company), storage_path('template/TEMPLATE-KONFIGURASI-PATROLI.xlsx'));
      Excel::import(new ImportPatrolScheduleConfig(1, $patrolScheduleConfig->patrol_schedule_id, Carbon::now()->month, Carbon::now()->year), storage_path('template/TEMPLATE-JADWAL-PATROLI.xlsx'));
    }
}
