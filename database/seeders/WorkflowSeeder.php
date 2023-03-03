<?php

namespace Database\Seeders;

use App\Models\Progress;
use App\Models\Workflow;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class WorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workflow  = [
            [
                "ID_WORKFLOW" => 1,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "1",
                "ID_PARENT" => "0",
                "DISPOSISI" => "0",
                "ID_PARENT_PREV" => "0",
                "ID_USER_GROUP" => 3,
                "NAMA" => "Pembuatan Rencana Kegiatan & Draf KAK & SPIH",
                "ADDITIONAL_ACTION" => null,
                "LABEL" => "Setujui Rencana Kegiatan",

            ],
            [
                "ID_WORKFLOW" => 2,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "2",
                "ID_PARENT" => "1",
                "DISPOSISI" => "1",
                "ID_PARENT_PREV" => "1",
                "ID_USER_GROUP" => 4,
                "NAMA" => "Approval Rencana kegiatan & Draf dokumen oleh PPTK",
                "ADDITIONAL_ACTION" => "approval_pptk",
                "LABEL" => "Setujui Rencana Kegiatan",

            ],
            [
                "ID_WORKFLOW" => 3,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "3",
                "ID_PARENT" => "2",
                "DISPOSISI" => "1",
                "ID_PARENT_PREV" => "1",
                "ID_USER_GROUP" => 7,
                "NAMA" => "Approval Rencana kegiatan & Draf dokumen oleh KASUBBAG TU",
                "ADDITIONAL_ACTION" => "approval_tu",
                "LABEL" => "Setujui Rencana Kegiatan",

            ],
            [
                "ID_WORKFLOW" => 4,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "4",
                "ID_PARENT" => "3",
                "DISPOSISI" => "1",
                "ID_PARENT_PREV" => "1",
                "ID_USER_GROUP" => 5,
                "NAMA" => "Approval Rencana kegiatan, Draf dokumen Dan Pembuatan Nomer Rencana Kegiatan oleh PPK",
                "ADDITIONAL_ACTION" => "generate_nomor",
                "LABEL" => "Setujui Rencana Kegiatan",

            ],
            [
                "ID_WORKFLOW" => 5,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "5",
                "ID_PARENT" => "4",
                "DISPOSISI" => "1",
                "ID_PARENT_PREV" => "1",
                "ID_USER_GROUP" => 3,
                "NAMA" => "Cetak draf KAK, SPIH Oleh PIC Kegiatan & Approval tanda tangan oleh PPK",
                "ADDITIONAL_ACTION" => "print_document",
                "LABEL" => "Cetak Dokumen",

            ],
            [
                "ID_WORKFLOW" => 6,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "6",
                "ID_PARENT" => "5",
                "DISPOSISI" => "0",
                "ID_PARENT_PREV" => "5",
                "ID_USER_GROUP" => 3,
                "NAMA" => "Upload Dokumen KAK, & SPIH yang telah di tanda tangani Oleh PPK",
                "ADDITIONAL_ACTION" => "upload_document",
                "LABEL" => "Upload Dokumen",

            ],
            [
                "ID_WORKFLOW" => 7,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "7",
                "ID_PARENT" => "6",
                "DISPOSISI" => "0",
                "ID_PARENT_PREV" => "6",
                "ID_USER_GROUP" => 3,
                "NAMA" => "Upload Dokumen Jawaban SPIH",
                "ADDITIONAL_ACTION" => "upload_document",
                "LABEL" => "Upload Dokumen",

            ],
            [
                "ID_WORKFLOW" => 8,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "8",
                "ID_PARENT" => "7",
                "DISPOSISI" => "0",
                "ID_PARENT_PREV" => "7",
                "ID_USER_GROUP" => 3,
                "NAMA" => "Pembuatan draft
- KAK,
- SPEK. TEKNIS,
- RAB,
-BOQ RHPS,
- HPS,
- SURAT PERMOHONAN PENGADAAN",
                "ADDITIONAL_ACTION" => "buat_draf",
                "LABEL" => null,

            ],
            [
                "ID_WORKFLOW" => 9,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "9",
                "ID_PARENT" => "8",
                "DISPOSISI" => "1",
                "ID_PARENT_PREV" => "7",
                "ID_USER_GROUP" => 4,
                "NAMA" => "Verifikasi Draf
- KAK,
- SPEK. TEKNIS,
- RAB,
- BOQ RHPS,
- HPS,
- SURAT PERMOHONAN PENGADAAN",
                "ADDITIONAL_ACTION" => "approval_pptk",
                "LABEL" => null,

            ],
            [
                "ID_WORKFLOW" => 10,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "10",
                "ID_PARENT" => "9",
                "DISPOSISI" => "1",
                "ID_PARENT_PREV" => "7",
                "ID_USER_GROUP" => 7,
                "NAMA" => "Approval Draf
- KAK,
- SPEK. TEKNIS,
- RAB,
- BOQ RHPS,
- HPS,
- SURAT PERMOHONAN PENGADAAN",
                "ADDITIONAL_ACTION" => "approval_tu",
                "LABEL" => null,

            ],
            [
                "ID_WORKFLOW" => 11,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "11",
                "ID_PARENT" => "10",
                "DISPOSISI" => "1",
                "ID_PARENT_PREV" => "7",
                "ID_USER_GROUP" => 3,
                "NAMA" => "Cetak Draf Dokumen dan Approval PPK ",
                "ADDITIONAL_ACTION" => "print_document",
                "LABEL" => "Cetak Dokumen",

            ],
            [
                "ID_WORKFLOW" => 12,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "12",
                "ID_PARENT" => "11",
                "DISPOSISI" => "0",
                "ID_PARENT_PREV" => "10",
                "ID_USER_GROUP" => 3,
                "NAMA" => "Upload Dokumen Yang telah di setujui oleh PPK, Dokumen yang di upload
- KAK,
- SPEK. TEKNIS,
- RAB,
- BOQ RHPS,
- HPS,
- SURAT PERMOHONAN PENGADAAN",
                "ADDITIONAL_ACTION" => "upload_document",
                "LABEL" => "Upload Dokumen",

            ],
            [
                "ID_WORKFLOW" => 13,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "13",
                "ID_PARENT" => "12",
                "DISPOSISI" => "0",
                "ID_PARENT_PREV" => "11",
                "ID_USER_GROUP" => 3,
                "NAMA" => "Kirim dokumen ke PPJB/POKJA, Dokumen yang di dikirim
- KAK,
- SPEK. TEKNIS,
- RAB,
- BOQ RHPS,
- HPS,
- SURAT PERMOHONAN PENGADAAN",
                "ADDITIONAL_ACTION" => null,
                "LABEL" => null,

            ],
            [
                "ID_WORKFLOW" => 14,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "14",
                "ID_PARENT" => "13",
                "DISPOSISI" => "1",
                "ID_PARENT_PREV" => "12",
                "ID_USER_GROUP" => 6,
                "NAMA" => "Verifikasi kelengkapan dokumen oleh PPJB/POKJA",
                "ADDITIONAL_ACTION" => null,
                "LABEL" => null,

            ],
            [
                "ID_WORKFLOW" => 15,
                "METODE_PENGADAAN" => "TENDER",
                "JENIS_PENGADAAN" => "BARANG",
                "SORT" => "15",
                "ID_PARENT" => "14",
                "DISPOSISI" => "0",
                "ID_PARENT_PREV" => "14",
                "ID_USER_GROUP" => 6,
                "NAMA" => "Buat surat laporan hasil pengadaan",
                "ADDITIONAL_ACTION" => null,
                "LABEL" => null,

            ]
        ];


        foreach ($workflow as $key => $work) {
            $workflowseed = Arr::except($work, ['progress']);
            $saveWorkflow = Workflow::create($workflowseed);
        }
    }
}
