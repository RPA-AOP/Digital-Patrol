<?php

namespace App\Imports;

use App\Imports\sheets\DataCategoryAbnormalEventSheetImport;
use App\Imports\sheets\DataCategorySheetImport;
use App\Imports\sheets\DataConfigSheetImport;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportPatrolConfig implements WithMultipleSheets, SkipsUnknownSheets
{
    use Importable;

    /**
     * @var int
     */
    public int $idCompany;
    /**
     * @var int
     */
    public int $idPatrolConfig;

    function __construct($idCompany, $idPatrolConfig)
    {
        $this->idCompany = $idCompany;
        $this->idPatrolConfig = $idPatrolConfig;
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was skipped");
    }


    public function sheets(): array
    {
        return [
            'KATEGORI' => new DataCategorySheetImport($this->idCompany,),
            'EVENT KATEGORI' => new DataCategoryAbnormalEventSheetImport($this->idCompany, $this->idPatrolConfig),
            'DATA' => new DataConfigSheetImport($this->idCompany, $this->idPatrolConfig),
        ];
    }
}
