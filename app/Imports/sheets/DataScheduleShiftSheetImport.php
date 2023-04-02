<?php

namespace App\Imports\sheets;

use App\Models\PatrolScheduleDetailConfig;
use App\Models\PatrolScheduleShift;
use App\Models\Users;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DataScheduleShiftSheetImport implements ToArray, WithCalculatedFormulas, WithHeadingRow
{

    /**
     * @var int
     */
    public int $idCompany;
    /**
     * @var int
     */
    public int $area;

    public function __construct($idCompany, $area)
    {
        $this->idCompany = $idCompany;
        $this->area = $area;
    }

    public function array(array $array)
    {
        PatrolScheduleShift::whereIdCompany($this->idCompany)
            ->whereArea($this->area)
            ->delete();
        foreach ($array as $item) {
            PatrolScheduleShift::updateOrCreate(
                [
                    'shift_code' => $item['shift_code'],
                    'id_company' => $this->idCompany,
                    'area' => $this->area,
                ], [
                'id_company' => $this->idCompany,
                'area' => $this->area,
                'shift_name' => $item['shift_name'],
                'shift_code' => $item['shift_code'],
                'start_hour' => Date::excelToDateTimeObject($item['start_hour'])
                    ->format('H:i'),
                'end_hour' => Date::excelToDateTimeObject($item['end_hour'])
                    ->format('H:i'),
                'status' => true
            ]);
        }
    }

    public function headingRow(): int
    {
        return 2;
    }

}
