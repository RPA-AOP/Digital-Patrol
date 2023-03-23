<?php

namespace Database\Seeders;

use App\Models\MasterPerangkatDaerah;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
            MasterCompanySeeders::class,
            MenusSeeder::class,
            UserGroupSeeder::class,
            UserGroupPrivilegeSeeder::class,
            UserSeeder::class,
            PatrolConfigSeeder::class,
//        ReportPatrolSeeder::class,
        ]
    );
  }
}
