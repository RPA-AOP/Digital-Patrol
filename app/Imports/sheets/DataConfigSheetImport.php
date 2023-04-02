<?php

namespace App\Imports\sheets;

use App\Models\DetailPatrolConfig;
use App\Models\MasterCategory;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataConfigSheetImport implements ToArray, WithCalculatedFormulas, WithHeadingRow
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

        $max_level = 0;
        foreach ($array as $index => $item) {
            if ($index == 0) continue;
            if (!$item[0]) continue;

            $category_id = null;
            if ($item[5] != null) {
                $existingCategory = MasterCategory::where('category_name', $item[5])
                    ->where('id_company', $this->idCompany)->first();
                if (!$existingCategory) {
                    $existingCategory = MasterCategory::create([
                        'category_name' => $item[5],
                        'id_company' => $this->idCompany
                    ]);
                }
                $existingCategory->refresh();
                $category_id = $existingCategory->id_category;
            }

            if ($max_level < $item[0])
                $max_level = $item[0];

            $detailConfig = DetailPatrolConfig::updateOrCreate(
                [
                    'id_company' => $this->idCompany,
                    'id_patrol_config' => $this->idPatrolConfig,
                    'code' => $item[1],
                ],
                [
                    'level' => $item[0],
                    'name' => $item[2],
                    'level_name' => $item[3],
                    'identification_key' => $item[4],
                    'parent_id' => $parentIdLevel[$item[0]],
                    'category_id' => $category_id
                ]
            );

            $detailConfig->refresh();
            $parentIdLevel[$item[0] + 1] = $detailConfig->id_detail_patrol_config;
        }

        DetailPatrolConfig::whereIdCompany($this->idCompany)
            ->whereIdPatrolConfig($this->idPatrolConfig)
            ->where('level', $max_level)
            ->update(['last_level' => true]);
    }

    public function headingRow(): int
    {
        return 4;
    }

}
