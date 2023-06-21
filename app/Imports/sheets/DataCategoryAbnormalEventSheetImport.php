<?php

namespace App\Imports\sheets;

use App\Models\MasterCategory;
use App\Models\MasterCategoryAbnormalEvent;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataCategoryAbnormalEventSheetImport implements ToArray, WithCalculatedFormulas, WithHeadingRow
{

    /**
     * @var int
     */
    public int $idCompany;

    public function __construct($idCompany)
    {
        $this->idCompany = $idCompany;
    }

    public function array(array $array)
    {
//        MasterCategoryAbnormalEvent::where('id_company', $this->idCompany)
//            ->delete();


        foreach ($array as $index => $item) {
            $category = MasterCategory::whereIdCompany($this->idCompany)
                ->where('category_code', $item['kode'])
                ->first();
            if ($category) {
                $event = MasterCategoryAbnormalEvent::updateOrCreate(
                    [
                        'id_company' => $this->idCompany,
                        'id_category' => $category->id_category,
                        'category_event' => $item['event'],
                    ],
                    [
                        'status' => true
                    ]);
            }

        }
    }

    public function headingRow(): int
    {
        return 1;
    }

}
