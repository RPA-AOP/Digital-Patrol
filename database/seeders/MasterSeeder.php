<?php

namespace Database\Seeders;

use App\Models\MasterKegiatan;
use App\Models\MasterKodeRekening;
use App\Models\MasterKomponen;
use App\Models\MasterProgram;
use App\Models\MasterRincianAktifitas;
use App\Models\MasterSubKegiatan;
use App\Models\MasterSubtitle;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = Carbon::now()->year;
    }
}
