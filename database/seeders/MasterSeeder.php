<?php

namespace Database\Seeders;

use App\Models\MasterKegiatan;
use App\Models\MasterKodeRekening;
use App\Models\MasterKomponen;
use App\Models\MasterProgram;
use App\Models\MasterRincianAktifitas;
use App\Models\MasterSubKegiatan;
use App\Models\MasterSubtitle;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = Carbon::now()->year;
        $master = [
            [
            "nama" => "PROGRAM PENYELENGGARAAN PENATAAN RUANG",
            "kode" => "1.03.12",
            "kegiatan" => [[
                "nama" => "Koordinasi dan Sinkronisasi Pemanfataan Ruang Daerah Provinsi",
                "kode" => "1.03.12.1.03",
                "sub_kegiatan" => [
                    [
                        "nama" => "Sistem Informasi Penataan Ruang",
                        "kode" => "1.03.12.1.03.02",
                        "rincian_aktifitas" => [
                            [
                                "nama" => "Pengembangan Sistem Informasi Cipta Karya Tata Ruang dan Pertanahan",
                                "kode" => "1.03.12.1.03.02",
                                "subtitle" => [
                                    [
                                        "nama" => "Tenaga Ahli Pembangunan, Pengembangan dan Pengelolaan Aplikasi dan Infrastruktur Cipta Karya, Tata Ruang dan Pertanahan",
                                        "kode" => "",
                                        "kode_rekening" => [
                                            [
                                                "nama" => "Belanja Jasa Tenaga Informasi dan Teknologi",
                                                "kode" => "5.1.02.02.01.0039",
                                                "komponen" => [
                                                    [
                                                        "nama" => "Tenaga Ahli Muda Golongan II-A S1 Pengalaman 5 Tahun",
                                                        "kode" => "9.1.2.26.01.01.002.00006",
                                                        "volume" => "10",
                                                        "satuan" => "Orang/Bulan",
                                                        "harga_satuan" => "16.650.000",
                                                        "pph_ppn_satuan" => "0",
                                                    ],
                                                    [
                                                        "nama" => "Assistant Professional Staff D3/S0 (3-6 Tahun)",
                                                        "kode" => "9.1.2.26.01.02.001.00009",
                                                        "volume" => "2",
                                                        "satuan" => "Orang/Bulan",
                                                        "harga_satuan" => "9.400.000",
                                                        "pph_ppn_satuan" => "0",
                                                    ],
                                                    [
                                                        "nama" => "Facilitator S1 (0-3 Tahun)",
                                                        "kode" => "9.1.2.26.01.02.001.00006",
                                                        "volume" => "1",
                                                        "satuan" => "Orang/Bulan",
                                                        "harga_satuan" => "7.600.000",
                                                        "pph_ppn_satuan" => "0",
                                                    ],
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "nama" => "Pakaian Kerja Tim Peliputan Media",
                                        "kode" => "",
                                        "kode_rekening" => [
                                            [
                                                "nama" => "Belanja Pakaian Dinas Harian (PDH)",
                                                "kode" => "5.1.02.01.01.0063",
                                                "komponen" => [
                                                    [
                                                        "nama" => "Pakaian Kerja Lapangan Baju seragam kerja, kemeja berkerah, bahan drill taipan, design dan warna custom, bordir custom",
                                                        "kode" => "1.1.7.01.03.09.003.00152",
                                                        "volume" => "2",
                                                        "satuan" => "Stell",
                                                        "harga_satuan" => "440.680",
                                                        "pph_ppn_satuan" => "48.475",
                                                    ],
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "nama" => "Pengelolaan Pelayanan Jaringan",
                                        "kode" => "",
                                        "kode_rekening" => [
                                            [
                                                "nama" => "Belanja Jasa Konsultansi Berorientasi Bidang-Telematika",
                                                "kode" => "5.1.02.02.09.0003",
                                                "komponen" => [
                                                    [
                                                        "nama" => "Tenaga Ahli Muda Golongan II-D S1 Pengalaman 8 Tahun",
                                                        "kode" => "9.1.2.26.01.01.002.00009",
                                                        "volume" => "2",
                                                        "satuan" => "Orang/Bulan",
                                                        "harga_satuan" => "21.150.000",
                                                        "pph_ppn_satuan" => "2.326.500",
                                                    ],
                                                    [
                                                        "nama" => "Tenaga Ahli Muda Golongan II-A S1 Pengalaman 5 Tahun",
                                                        "kode" => "9.1.2.26.01.01.002.00006",
                                                        "volume" => "3",
                                                        "satuan" => "Orang/Bulan",
                                                        "harga_satuan" => "1.831.500",
                                                        "pph_ppn_satuan" => "16.650.000",
                                                    ],
                                                    [
                                                        "nama" => "Tenaga Ahli Pratama Golongan I-C S1 Pengalaman 3 Tahun",
                                                        "kode" => "9.1.2.26.01.01.002.00003",
                                                        "volume" => "3",
                                                        "satuan" => "Orang/Bulan",
                                                        "harga_satuan" => "13.650.000",
                                                        "pph_ppn_satuan" => "1.501.500",
                                                    ],
                                                    [
                                                        "nama" => "Computer Operator (Typist)",
                                                        "kode" => "9.1.2.26.01.02.002.00232",
                                                        "volume" => "2",
                                                        "satuan" => "Orang/Bulan",
                                                        "harga_satuan" => "5.200.000",
                                                        "pph_ppn_satuan" => "572.000",
                                                    ],
                                                    [
                                                        "nama" => "Laporan Bulanan Pengawasan",
                                                        "kode" => "9.1.2.06.02.01.001.00015",
                                                        "volume" => "3",
                                                        "satuan" => "Buku",
                                                        "harga_satuan" => "273.740",
                                                        "pph_ppn_satuan" => "30.111",
                                                    ],
                                                    [
                                                        "nama" => "Laporan Akhir",
                                                        "kode" => "9.1.2.06.02.01.001.00023",
                                                        "volume" => "2",
                                                        "satuan" => "Buku",
                                                        "harga_satuan" => "410.610",
                                                        "pph_ppn_satuan" => "45.167",
                                                    ],
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "nama" => "Perencanaan Arsitektur Infrastruktur Teknologi Informasi DCKTRP ",
                                        "kode" => "",
                                        "kode_rekening" => [
                                            [
                                                "nama" => "Belanja Jasa Konsultansi Berorientasi Bidang-Telematika",
                                                "kode" => "5.1.02.02.09.0003",
                                                "komponen" => [
                                                    [
                                                        "nama" => "Tenaga Ahli Muda Golongan II-D S1 Pengalaman 8 Tahun",
                                                        "kode" => "9.1.2.26.01.01.002.00009",
                                                        "volume" => "3",
                                                        "satuan" => "Orang/Bulan",
                                                        "harga_satuan" => "21.150.000",
                                                        "pph_ppn_satuan" => "2.326.500",
                                                    ],
                                                    [
                                                        "nama" => "Tenaga Ahli Pratama Golongan I-C S1 Pengalaman 3 Tahun",
                                                        "kode" => "9.1.2.26.01.01.002.00003",
                                                        "volume" => "3",
                                                        "satuan" => "Orang/Bulan",
                                                        "harga_satuan" => "13.650.000",
                                                        "pph_ppn_satuan" => "1.501.500",
                                                    ],
                                                    [
                                                        "nama" => "Computer Operator (Typist)",
                                                        "kode" => "9.1.2.26.01.02.002.00232",
                                                        "volume" => "3",
                                                        "satuan" => "Orang/Bulan",
                                                        "harga_satuan" => "5.200.000",
                                                        "pph_ppn_satuan" => "572.000",
                                                    ],
                                                    [
                                                        "nama" => "Laporan Bulanan Pengawasan",
                                                        "kode" => "9.1.2.06.02.01.001.00015",
                                                        "volume" => "3",
                                                        "satuan" => "Buku",
                                                        "harga_satuan" => "273.740",
                                                        "pph_ppn_satuan" => "30.111",
                                                    ],
                                                    [
                                                        "nama" => "Laporan Akhir",
                                                        "kode" => "9.1.2.06.02.01.001.00015",
                                                        "volume" => "2",
                                                        "satuan" => "Buku",
                                                        "harga_satuan" => "410.610",
                                                        "pph_ppn_satuan" => "45.167",
                                                    ],

                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "nama" => "Pengadaan Perangkat Lunak Komputer",
                                        "kode" => "",
                                        "kode_rekening" => [
                                            [
                                                "nama" => "Belanja Modal Peralatan Komputer Lainnya",
                                                "kode" => "5.2.02.10.02.0005",
                                                "komponen" => [
                                                    [
                                                        "nama" => "Microsoft Office 2019",
                                                        "kode" => "1.5.3.01.01.05.001.00073",
                                                        "volume" => "3",
                                                        "satuan" => "Unit",
                                                        "harga_satuan" => "6.638.000",
                                                        "pph_ppn_satuan" => "730.180",
                                                    ],
                                                ]
                                            ]
                                        ]
                                    ],
                                    [
                                        "nama" => "Penyelenggaraan ISO 27001:2013",
                                        "kode" => "",
                                        "kode_rekening" => [
                                            [
                                                "nama" => "Belanja Jasa Konsultansi Berorientasi Layanan-Jasa Khusus",
                                                "kode" => "5.1.02.02.09.0014",
                                                "komponen" => [
                                                    [
                                                        "nama" => "Certification ISO 27001:2013 Information Security Management System
                                                                    1. Annual Management Fee,
                                                                    2. Pre – Assessment (optional)
                                                                    3. Initial Assessment Visit - Application Fee - Stage 1 Assessment - Stage 2 Assessment",
                                                        "kode" => "9.1.2.03.08.01.001.00042",
                                                        "volume" => "3",
                                                        "satuan" => "Unit",
                                                        "harga_satuan" => "55.000.000",
                                                        "pph_ppn_satuan" => "6.050.000",
                                                    ]
                                                ]
                                            ],
                                            [
                                                "nama" => "Belanja Jasa Konsultansi Berorientasi Bidang-Telematika",
                                                "kode" => "9.1.2.19.04.01.001.00005",
                                                "komponen" => [
                                                    [
                                                        "nama" => "Audit Surveillance ISO 27001, Pendampingan Teknis ISO 27001 dan Surveillance ISO 27001",
                                                        "kode" => "9.1.2.19.04.01.001.00005",
                                                        "volume" => "3",
                                                        "satuan" => "Kegiatan",
                                                        "harga_satuan" => "6.050.000",
                                                        "pph_ppn_satuan" => "12.402.500",
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]]
                        ]
                    ]
                ]
            ]
            ]
        ]
        ];
        foreach ($master as $program) {
            $masterProgram = Arr::except($program, ['kegiatan']);
            // $masterProgram['tahun'] = $year;
            $savedMasterProgram = MasterProgram::create($masterProgram);
            foreach ($program['kegiatan'] as $kegiatan) {
                $masterKegiatan = Arr::except($kegiatan, ['sub_kegiatan']);
                $masterKegiatan['id_program'] = $savedMasterProgram->id_program;
                // $masterKegiatan['tahun'] = $year;
                $savedMasterKegiatan = MasterKegiatan::create($masterKegiatan);
                foreach ($kegiatan['sub_kegiatan'] as $subKegiatan) {
                    $masterSubKegiatan = Arr::except($subKegiatan, ['rincian_aktifitas']);
                    // $masterSubKegiatan['tahun'] = $year;
                    $masterSubKegiatan['id_kegiatan'] = $savedMasterKegiatan->id_kegiatan;
                    $savedMasterSubKegiatan = MasterSubKegiatan::create($masterSubKegiatan);
                    foreach ($subKegiatan['rincian_aktifitas'] as $rincianAktifitas) {
                        $masterRincianAktifitas = Arr::except($rincianAktifitas, ['subtitle']);
                        $masterRincianAktifitas['tahun'] = $year;
                        $masterRincianAktifitas['id_sub_kegiatan'] = $savedMasterSubKegiatan->id_sub_kegiatan;
                        $savedMasterRincianAktifitas = MasterRincianAktifitas::create($masterRincianAktifitas);
                        foreach ($rincianAktifitas['subtitle'] as $subtitle) {
                            $masterSubtitle = Arr::except($subtitle, ['kode_rekening']);
                            $masterSubtitle['tahun'] = $year;
                            $masterSubtitle['id_rincian_aktifitas'] = $savedMasterRincianAktifitas->id_rincian_aktifitas;
                            $savedMasterSubtitle = MasterSubtitle::create($masterSubtitle);
                            foreach ($subtitle['kode_rekening'] as $kodeRekening) {
                                $masterKodeRekening = Arr::except($kodeRekening, ['komponen']);
                                $masterKodeRekening['tahun'] = $year;
                                $masterKodeRekening['id_subtitle'] = $savedMasterSubtitle->id_subtitle;
                                $savedKodeRekening = MasterKodeRekening::create($masterKodeRekening);
                                foreach ($kodeRekening['komponen'] as $komponen) {
                                    $masterKomponen = $komponen;
                                    $masterKomponen['harga_satuan'] = str_replace('.','',$komponen['harga_satuan'], );
                                    $masterKomponen['pph_ppn_satuan'] = str_replace('.','',$komponen['pph_ppn_satuan'], );
                                    $masterKomponen['tahun'] = $year;
                                    $masterKomponen['id_kode_rekening'] = $savedKodeRekening->id_kode_rekening;
                                    MasterKomponen::create($masterKomponen);
                                }
                            }
                        }
                    }

                }
            }
        }
    }
}
