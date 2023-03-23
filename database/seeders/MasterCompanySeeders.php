<?php

namespace Database\Seeders;

use App\Models\MasterCompany;
use Illuminate\Database\Seeder;

class MasterCompanySeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterCompany::create([
            'company_name' => 'PT. EXAMPLE',
            'alamat' => 'Jl.ABC',
            'luas_tanah' => 1200,
            'luas_bangunan' => 1000,
            'status_bangunan' => 'Hak Milik',
            'jumlah_karyawan_kontrak' => 10,
            'jumlah_karyawan_outsource' => 100,
            'jumlah_karyawan_tetap' => 1000,
            'nama_produk' => 'Produk ABCD',
            'proses_utama' => 'Produksi ABCD',
            'lat' => 0,
            'long' => 0,
            'status' => true
        ]);
    }
}
