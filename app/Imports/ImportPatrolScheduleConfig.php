<?php

namespace App\Imports;

use App\Imports\sheets\DataScheduleSheetImport;
use App\Imports\sheets\DataSheetImport;
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

  function __construct($idCompany, $idPatrolScheduleConfig, $month, $year)
  {
    $this->idCompany = $idCompany;
    $this->idPatrolScheduleConfig = $idPatrolScheduleConfig;
    $this->month = $month;
    $this->year = $year;
  }

  public function onUnknownSheet($sheetName)
  {
    info("Sheet {$sheetName} was skipped");
  }


  public function sheets(): array
  {
    return [
      'JADWAL PATROLI' => new DataScheduleSheetImport($this->idCompany, $this->idPatrolScheduleConfig, $this->month, $this->year)
    ];
  }
}
