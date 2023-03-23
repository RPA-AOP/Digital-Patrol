<?php

namespace App\Imports;

use App\Imports\sheets\DataScheduleSheetImport;
use App\Imports\sheets\DataScheduleShiftSheetImport;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportPatrolScheduleConfig implements WithMultipleSheets, SkipsUnknownSheets
{
    use Importable;

    /**
     * @var int
     */
    public int $idCompany;
    /**
     * @var int
     */
    public int $idPatrolScheduleConfig;
    private int $month;
    private int $year;
    private int $area;

    function __construct($idCompany, $idPatrolScheduleConfig, $month, $year, $area)
    {
        $this->idCompany = $idCompany;
        $this->idPatrolScheduleConfig = $idPatrolScheduleConfig;
        $this->month = $month;
        $this->year = $year;
        $this->area = $area;
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was skipped");
    }


    public function sheets(): array
    {
        return [
            'SHIFT' => new DataScheduleShiftSheetImport($this->idCompany, $this->area),
            'JADWAL PATROLI' => new DataScheduleSheetImport($this->idCompany, $this->idPatrolScheduleConfig, $this->month, $this->year),
        ];
    }
}
