<?php

namespace App\Imports;

use App\Imports\sheets\DataSheetImport;
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
            'SAMPLE DATA' => new DataSheetImport($this->idCompany, $this->idPatrolConfig)
        ];
    }
}
