<?php

namespace App\Http\Controllers;

use App\Models\DokumenRencanaKegiatan;
use App\Models\FileUpload;
use App\Models\MasterRincianAktifitas;
use App\Models\RencanaKegiatan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    function download(Request $request): Response|StreamedResponse
    {
        $file = $request->get('file');
        if (Storage::exists($file)) {
            return Storage::download($file);
        } else {
            $data['title'] = '404';
            $data['name'] = 'File not found';
            return response()->view('errors.404', $data, 404);
        }
    }

    function preview(Request $request): BinaryFileResponse
    {
        $fileRequest = $request->get('file');
        if (Storage::exists($fileRequest)) {
            $mimeType = Storage::mimeType($fileRequest);
            $headers = [
                'Content-Type' => $mimeType
            ];
            $filePath = Storage::path($fileRequest);

            return response()->file($filePath, $headers);
        } else {
            abort(404, 'File not found!');
        }
    }

    function buildKAK(Request $request)
    {

    }

    function previewKAK(Request $request)
    {
        $rincianAktifitas = MasterRincianAktifitas::query()
            ->with('subKegiatan')
            ->with('subKegiatan.kegiatan')
            ->with('subKegiatan.kegiatan.program')
            ->where('id_rincian_aktifitas',
                $request->post('data-detailkegiatan')['rincian_aktifitas'])
            ->first();
        $param = [
            'template' => [
                'template_name' => 'Kerangka Acuan Kerja',
                'template_view' => 'barang.tender.kak',
            ],
            'data' => $request->post(),
            'rincianAktifitas' => $rincianAktifitas
        ];

        $pdf = PDF::loadview('modules.templates.print', $param);
        return $pdf->stream('Kerangka Acuan Kerja.pdf');
//        return view('modules.templates.print', $param);
    }

    function previewSPPH(Request $request)
    {

        $param = [
            'template' => [
                'template_name' => 'Surat Permintaan Penawaran Harga.pdf',
                'template_view' => 'barang.tender.spph',
            ],
            'data' => $request->post(),
        ];

        $pdf = PDF::loadview('modules.templates.print', $param);
        return $pdf->stream('Surat Permintaan Penawaran Harga.pdf');
//        return view('modules.templates.print', $param);
    }


    function previewDocument(Request $request)
    {
        $idDocument = $request->get('id');
        $documents = DokumenRencanaKegiatan::query()
            ->where('id_dokumen_rencana_kegiatan', $idDocument)
            ->first();
        $rencanaKegiatan = RencanaKegiatan::query()->find($documents->id_rencana_kegiatan);
        $dataDocument = json_decode($documents->data_dokumen, true);
        $param = [
            'template' => [
                'template_name' => FileUpload::TENDER[$documents->jenis_dokumen] . '.pdf',
                'template_view' => 'barang.tender.' . strtolower($documents->jenis_dokumen),
            ],
            'data' => $this->parseDataDokumen($dataDocument),
            'rencanaKegiatan' => $rencanaKegiatan
        ];
        switch ($documents->jenis_dokumen) {
            case 'KAK':
                $param['rincianAktifitas'] = MasterRincianAktifitas::query()
                    ->with('subKegiatan')
                    ->with('subKegiatan.kegiatan')
                    ->with('subKegiatan.kegiatan.program')
                    ->where('id_rincian_aktifitas',
                        $rencanaKegiatan->id_rincian_aktifitas)
                    ->first();
                break;
        }
        $pdf = PDF::loadview('modules.templates.print', $param);
        return $pdf->stream('Surat Permintaan Penawaran Harga.pdf');
//        return view('modules.templates.print', $param);

    }

    function get_numerics($str)
    {
        return preg_replace('/\D+/', '', $str);
    }

    function parseDataDokumen($dataDokumen)
    {
        $result = [];
        foreach ($dataDokumen as $index => $item) {
            if (str_contains($index, 'data-kak-datakomponen')) {
                $result['data-kak-datakomponen'][] = $item;
            } elseif (str_contains($index, 'detailkegiatan')) {
                if (str_contains($index, 'nomor_sirup')) {
                    $result['data-detailkegiatan']['nomor_sirup'] = $item;
                }
                if (str_contains($index, 'metode_pengadaan')) {
                    $result['data-detailkegiatan']['metode_pengadaan'] = $item;
                }
                if (str_contains($index, 'jenis_pengadaan')) {
                    $result['data-detailkegiatan']['jenis_pengadaan'] = $item;
                }
                if (str_contains($index, 'program')) {
                    $result['data-detailkegiatan']['program'] = $item;
                }
                if (str_contains($index, 'kegiatan')) {
                    $result['data-detailkegiatan']['kegiatan'] = $item;
                }
                if (str_contains($index, 'sub_kegiatan')) {
                    $result['data-detailkegiatan']['sub_kegiatan'] = $item;
                }
                if (str_contains($index, 'rincian_aktifitas')) {
                    $result['data-detailkegiatan']['rincian_aktifitas'] = $item;
                }
            } elseif (str_contains($index, 'data-kak')) {
                $key = $this->get_numerics($index);
                if (str_contains($index, 'point')) {
                    $result['data-kak'][$key]['point'] = $item;
                }
                if (str_contains($index, 'uraian')) {
                    $result['data-kak'][$key]['uraian'] = $item;
                }

            } elseif (str_contains($index, 'totalSelectedText')) {
                $result['totalSelectedText'] = $item;
            } elseif (str_contains($index, 'data-spph-komponen')) {
                $result['data-spph-komponen'][] = $item;
            } elseif (str_contains($index, 'speksifikasi')) {
                $result['speksifikasi'][] = $item;
            } else {
                $result[$index] = $item;

            }
        }
        return $result;
    }
}
