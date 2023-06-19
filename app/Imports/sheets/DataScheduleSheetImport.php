<?php

namespace App\Imports\sheets;

use App\Models\PatrolScheduleDetailConfig;
use App\Models\PatrolScheduleShift;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataScheduleSheetImport implements ToArray, WithCalculatedFormulas, WithHeadingRow
{

    /**
     * @var int
     */
    public int $idCompany;
    /**
     * @var int
     */
    public int $idPatrolScheduleConfig;
    private $month;
    private $year;

    public function __construct($idCompany, $idPatrolScheduleConfig, $month, $year)
    {
        $this->idCompany = $idCompany;
        $this->idPatrolScheduleConfig = $idPatrolScheduleConfig;
        $this->month = $month;
        $this->year = $year;
    }

    public function array(array $array)
    {
        DB::table('patrol_schedule_detail')->where('patrol_schedule_id', $this->idPatrolScheduleConfig)
            ->whereMonth('patrol_date', $this->month)
            ->delete();

        foreach ($array as $index => $item) {
            if (!$item[0]) continue;
            foreach ($item as $k => $v) {

                if ($k == 0) continue;
                if ($v == null) continue;
                $patrolDate = Carbon::createFromFormat('d-n-Y', "{$item[0]}-{$this->month}-{$this->year}");

                $user = Users::where('npk', $k)
                    ->where('id_company', $this->idCompany)
                    ->where('id_user_group', 4)->first();

                if (!$user){
                    $user = new Users();
                    $user->username = $k;
                    $user->password = Hash::make($k);
                    $user->id_company = $this->idCompany;
                    $user->name = $k;
                    $user->npk = $k;
                    $user->id_user_group = 4;
                    $user->status = 1;
                    $user->created_by = 1;
                    $user->save();
                    $user = $user->refresh();
                }

                $shift = PatrolScheduleShift::where('shift_name', $v)
                    ->orWhere('shift_code', $v)->first();
                if (!$shift) {
                    $shift = new PatrolScheduleShift();
                    $shift->id_company = $this->idCompany;
                    $shift->shift_name = $v;
                    $shift->shift_code = $v;
                    $shift->status = true;
                    $shift->save();
                }
                $detailConfig = new PatrolScheduleDetailConfig();
                $detailConfig->patrol_schedule_id = $this->idPatrolScheduleConfig;
                $detailConfig->patrol_schedule_shift_id = $shift->patrol_schedule_shift_id;
                if ($user)
                    $detailConfig->id_user = $user->id_user;
                $detailConfig->patrol_date = $patrolDate;
                $detailConfig->status = true;
                $detailConfig->save();
            }
        }
    }

    public function headingRow(): int
    {
        return 6;
    }

}
