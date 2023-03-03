<?php

namespace App\Helpers;

class Constant
{
    public const METODE_PENGADAAN = [
        'tender'            => 'TENDER',
        'lelang'            => 'LELANG',
        'e-purchasing'      => 'E-PURCHASING',
        'pengadaan_langsung'=> 'PENGADAAN LANGSUNG'
    ];

    public const JENIS_PENGADAAN = [
        'barang'        => 'BARANG',
        'jasa'          => 'JASA',
        'jasa_konsultan'=> 'JASA KONSULTAN',
        'jasa_lainnya'  => 'JASA LAINNYA'
    ];
}
