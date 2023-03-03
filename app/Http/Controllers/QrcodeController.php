<?php

namespace App\Http\Controllers;

use App\Helpers\QrcodeGen;
use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    public function index(){
        // nomor kegiatan ?
        // jenis kegiatan ?
        // id kegiatan ?
        // encryp jangan kepanjangan
        $url = "rencana-kegiatan/verifikasi-dokumen";
        $param = [
            'jenis_kegiatan' => 'BAST',
            'id_kegiatan' => 1,
        ];
        $data['qrcode'] = (new QrcodeGen())->QrcodeGen($url, $param);

        return view('modules.qrcode.index', $data);
    }

    public function decrypQrCode(Request $request){
        dd($request->key);
    }
}
