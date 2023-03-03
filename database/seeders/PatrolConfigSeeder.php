<?php

namespace Database\Seeders;

use App\Models\PatrolConfig;
use Illuminate\Database\Seeder;

class PatrolConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PatrolConfig::create(['id_company'=>1, 'created_by'=>1, 'status'=>true]);
    }
}
