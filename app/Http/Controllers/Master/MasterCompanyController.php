<?php

namespace App\Http\Controllers\Master;


use App\Helpers\Permission;
use App\Http\Controllers\Controller;
use App\Models\MasterCompany;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MasterCompanyController extends Controller
{
    public function index()
    {
        $permission = Permission::get();
//        if ($permission->has_view) {
//            return view('modules.master.company.index', compact('permission'));
//        } else {
//            return abort(403, 'Anda tidak memiliki akses pada menu ini');
//        }
        return view('modules.master.company.index', compact('permission'));

    }

    public function list()
    {
//        $permission = Permission::get();
//        if (!$permission->has_view) {
//            return response()->json([
//                'status' => 'error',
//                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
//            ]);
//        }
        $models = MasterCompany::all();
        return DataTables::of($models)->addIndexColumn()->make(true);
    }

    public function create()
    {

        return view('modules.master.company.create');

    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'nama_perusahaan' => 'required|max:255',
                'alamat' => 'required',
                'luas_tanah' => 'required|int',
                'luas_bangunan' => 'required|int',
                'status_bangunan' => 'required',
                'karyawan_tetap' => 'required|int',
                'karyawan_kontrak' => 'required|int',
                'karyawan_outsource' => 'required|int',
                'nama_produk' => 'required',
                'proses_utama' => 'required',
                'lat' => 'required',
                'long' => 'required',
            ]
        );
        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $nama_perusahaan = $request->nama_perusahaan;
        $nama_produk = $request->nama_produk;
        $proses_utama = $request->proses_utama;
        $luas_tanah = $request->luas_tanah;
        $luas_bangunan = $request->luas_bangunan;
        $status_bangunan = $request->status_bangunan;
        $karyawan_tetap = $request->karyawan_tetap;
        $karyawan_kontrak = $request->karyawan_kontrak;
        $karyawan_outsource = $request->karyawan_outsource;
        $lat = $request->lat;
        $long = $request->long;
        $alamat = $request->alamat;

        $Perusahaan = new MasterCompany();
        $Perusahaan->company_name = $nama_perusahaan;
        $Perusahaan->alamat = $alamat;
        $Perusahaan->nama_produk = $nama_produk;
        $Perusahaan->luas_tanah = $luas_tanah;
        $Perusahaan->proses_utama = $proses_utama;
        $Perusahaan->luas_bangunan = $luas_bangunan;
        $Perusahaan->status_bangunan = $status_bangunan;
        $Perusahaan->jumlah_karyawan_tetap = $karyawan_tetap;
        $Perusahaan->jumlah_karyawan_kontrak = $karyawan_kontrak;
        $Perusahaan->jumlah_karyawan_outsource = $karyawan_outsource;
        $Perusahaan->lat = $lat;
        $Perusahaan->long = $long;
        $Perusahaan->save();
        $message = 'Data Perusahaan Berhasil Disimpan';

        return redirect()->route('master.company.index')
            ->with('success', 'Successfully add company');
    }

    public function edit($id)
    {
        $data = MasterCompany::find($id);
        return view('modules.master.company.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_perusahaan' => 'required|max:255',
            'alamat' => 'required',
            'luas_tanah' => 'required|int',
            'luas_bangunan' => 'required|int',
            'status_bangunan' => 'required',
            'karyawan_tetap' => 'required|int',
            'karyawan_kontrak' => 'required|int',
            'karyawan_outsource' => 'required|int',
            'nama_produk' => 'required',
            'proses_utama' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);

        $nama_perusahaan = $request->nama_perusahaan;
        $nama_produk = $request->nama_produk;
        $proses_utama = $request->proses_utama;
        $luas_tanah = $request->luas_tanah;
        $luas_bangunan = $request->luas_bangunan;
        $status_bangunan = $request->status_bangunan;
        $karyawan_tetap = $request->karyawan_tetap;
        $karyawan_kontrak = $request->karyawan_kontrak;
        $karyawan_outsource = $request->karyawan_outsource;
        $lat = $request->lat;
        $long = $request->long;
        $alamat = $request->alamat;

        $Perusahaan = MasterCompany::find($id);
        $Perusahaan->company_name = $nama_perusahaan;
        $Perusahaan->alamat = $alamat;
        $Perusahaan->nama_produk = $nama_produk;
        $Perusahaan->luas_tanah = $luas_tanah;
        $Perusahaan->proses_utama = $proses_utama;
        $Perusahaan->luas_bangunan = $luas_bangunan;
        $Perusahaan->status_bangunan = $status_bangunan;
        $Perusahaan->jumlah_karyawan_tetap = $karyawan_tetap;
        $Perusahaan->jumlah_karyawan_kontrak = $karyawan_kontrak;
        $Perusahaan->jumlah_karyawan_outsource = $karyawan_outsource;
        $Perusahaan->lat = $lat;
        $Perusahaan->long = $long;
        $Perusahaan->save();
        $message = 'Data Perusahaan Berhasil Disimpan';

        $result = [
            'status' => true,
            'message' => $message
        ];
        return redirect()->route('master.company.index')
            ->with('success', 'Successfully add company');
    }

}
