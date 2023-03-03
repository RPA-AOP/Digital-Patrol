<?php

namespace App\Imports\sheets;

use App\Models\DetailPatrolConfig;
use App\Models\MasterCategory;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataSheetImport implements ToArray, WithCalculatedFormulas, WithHeadingRow
{

    /**
     * @var int
     */
    public int $idCompany;
    /**
     * @var int
     */
    public int $idPatrolConfig;

    public function __construct($idCompany, $idPatrolConfig)
    {
        $this->idCompany = $idCompany;
        $this->idPatrolConfig = $idPatrolConfig;
    }

    public function array(array $array)
    {
        $parentIdLevel = [
            0 => null,
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null
        ];
        foreach ($array as $index => $item) {
            if ($index == 0) continue;
            if (!$item[0]) continue;

            $detailConfig = new DetailPatrolConfig();
            $detailConfig->id_company = $this->idCompany;
            $detailConfig->id_patrol_config = $this->idPatrolConfig;
            $detailConfig->level = $item[0];
            $detailConfig->code = $item[1];
            $detailConfig->name = $item[2];
            $detailConfig->level_name = $item[3];
            $detailConfig->identification_key = $item[4];
            $detailConfig->parent_id = $parentIdLevel[$item[0]];


            if ($item[5] != null) {
                $existingCategory = MasterCategory::where('category_name', $item[5])
                    ->where('id_company', $this->idCompany)->first();
                if (!$existingCategory) {
                    $existingCategory = MasterCategory::create([
                        'category_name' => $item[5],
                        'id_company' => $this->idCompany
                    ]);
                    $existingCategory->refresh();
                }
                $detailConfig->category_id = $existingCategory->id_category;
            }
            $detailConfig->save();
            $detailConfig->refresh();

            $parentIdLevel[$item[0] + 1] = $detailConfig->id_detail_patrol_config;

        }
    }

    public function headingRow(): int
    {
        return 4;
    }

}
