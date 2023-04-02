<?php

namespace App\Imports\sheets;

use App\Models\MasterCategory;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataCategorySheetImport implements ToArray, WithCalculatedFormulas, WithHeadingRow
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

        foreach ($array as $index => $item) {
            MasterCategory::updateOrCreate(
                [
                    'id_company' => $this->idCompany,
                    'category_code' => $item['kode_kategori'],
                ],
                [
                    'category_name' => $item['nama_kategori'],
                    'status' => true
                ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

}
