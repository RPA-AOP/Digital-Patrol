<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use App\Models\Menus;
use App\Models\UserGroup;
use App\Models\UserGroupPrivilege;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;


class UserGroupController extends Controller
{
    public function index()
    {
        $permission = Permission::get();
        if (!$permission->has_view) {
            return abort(403, 'Anda tidak memiliki akses pada menu ini');
        }

        $params = [];
        $params['permission'] = $permission;

        $params['type_user_group'] = [
            [
                'label' => 'Operator',
                'value' => 'OPERATOR'
            ],
            [
                'label' => 'Pemohon',
                'value' => 'PEMOHON'
            ]
        ];

        $menu = Menus::where('is_hidden', 0)->select('title', 'id_menu')->orderBy('sort', 'ASC')->get();
        foreach ($menu as $mn) {
            $mn->has_view = 0;
            $mn->has_create = 0;
            $mn->has_update = 0;
            $mn->has_delete = 0;
        }

        $params['default_privilege'] = $menu;

        $params['unit_kerja'] = UnitKerja::where('status', 1)->select('id_unit_kerja', 'name')->get();
        $params['jabatan'] = Jabatan::where('status', 1)->select('id_jabatan', 'name')->get();

        return view('modules.user_group.index', $params);
    }

    public function list()
    {
        $permission = Permission::get();
        if ($permission->has_view) {
            $data = UserGroup::where('status', 1)->with('user_created:id_user,nama', 'user_updated:id_user,nama')->get();
            foreach ($data as $dt) {
                $jabatan = Jabatan::where('id_jabatan', $dt->id_jabatan)->select('name')->first();
                if ($jabatan) {
                    $dt->jabatanName = $jabatan->name;
                }
                $unit_kerja = UnitKerja::where('id_unit_kerja', $dt->id_unit_kerja)->select('name')->first();
                if ($unit_kerja) {
                    $dt->unit_kerja = $unit_kerja->name;
                }

                if ($dt->user_created !== null) {
                    $dt->usercreated = $dt->user_created->nama;
                } else {
                    $dt->usercreated = null;
                }

                if ($dt->user_updated !== null) {
                    $dt->userupdated = $dt->user_updated->nama;
                } else {
                    $dt->userupdated = null;
                }
                unset($dt->user_updated);
                unset($dt->user_created);
            }

            return DataTables::of($data)->addIndexColumn()->make(true);
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
            ]);
        }
    }

    public function detail(Request $request)
    {
        $permission = Permission::get();
        if (!$permission->has_view) {
            return response()->json([
                'status' => 'error',
                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
            ]);
        }

        if ($request->id) {
            $data = UserGroup::where('id_user_group', $request->id)->where('status', 1)->first();
            if ($data) {
                $menu = Menus::where('is_hidden', 0)->select('id_menu', 'title')->orderBy('sort', 'ASC')->get();
                $privileges = [];
                foreach ($menu as $mn) {
                    $priv = UserGroupPrivilege::where('id_menu', $mn->id_menu)
                        ->where('id_user_group', $data->id_user_group)
                        ->select('has_create', 'has_view', 'has_edit', 'has_delete', 'has_download')
                        ->first();
                    if ($priv) {
                        $mn->has_create = $priv->has_create;
                        $mn->has_view = $priv->has_view;
                        $mn->has_edit = $priv->has_edit;
                        $mn->has_download = $priv->has_download;
                        $mn->has_delete = $priv->has_delete;
                    } else {
                        $mn->has_create = 0;
                        $mn->has_view = 0;
                        $mn->has_edit = 0;
                        $mn->has_download = 0;
                        $mn->has_delete = 0;
                    }

                    array_push($privileges, $mn);
                }

                $data->privileges = $privileges;

                return response()->json([
                    'status' => 'success',
                    'msg' => 'berhasil mendapatkan data',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'data tidak ditemukan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'bad request'
            ]);
        }
    }

    public function add(Request $request)
    {
        $permission = Permission::get();
        if (!$permission->has_create) {
            return response()->json([
                'status' => 'error',
                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
            ]);
        }

        $rules = [
            'jabatan' => 'required|integer',
            'unit_kerja' => 'required|integer',
            'type' => 'required|in:PEMOHON,OPERATOR'
        ];

        $errorRules = [
            'jabatan.required' => 'Jabatan harus dipilih',
            'jabatan.integer' => 'Jabatan tidak valid',
            'unit_kerja.required' => 'Unit Kerja harus dipilih',
            'unit_kerja.integer' => 'Unit Kerja tidak valid',
            'type.required' => 'Tipe User Group harus dipilih',
            'type.in' => 'Tipe User Group Tidak Valid'
        ];

        $validator = Validator::make($request->all(), $rules, $errorRules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => $validator->messages()->first()
            ]);
        }

        if ($request->privilege) {
            json_encode($request->privilege);

            if (json_last_error() != JSON_ERROR_NONE) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'bad request'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'bad request'
            ]);
        }

        // CHECK DATA ALREADY EXIST
        $is_exist = UserGroup::where('status', 1)->where('id_unit_kerja', $request->unit_kerja)->where('id_jabatan', $request->jabatan)->first();
        if ($is_exist) {
            return response()->json([
                'status' => 'error',
                'msg' => 'User Group sudah terdaftar'
            ]);
        }

        $UG = new UserGroup();
        $UG->id_jabatan = $request->jabatan;
        $UG->id_unit_kerja = $request->unit_kerja;
        $UG->type = $request->type;
        $UG->status = 1;
        $UG->created_by = Session::get('id_user');

        if (!$UG->save()) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Terjadi kesalahan pada database'
            ]);
        }

        foreach ($request->privilege as $priv) {
            $UGP = new UserGroupPrivilege();
            $UGP->id_user_group = $UG->id_user_group;
            $UGP->id_menu = $priv['id_menu'];
            $UGP->has_view = $priv['has_view'];
            $UGP->has_create = $priv['has_create'];
            $UGP->has_edit = $priv['has_edit'];
            $UGP->has_download = $priv['has_download'];
            $UGP->has_delete = $priv['has_delete'];
            $UGP->created_by = Session::get('id');
            $UGP->save();
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Berhasil membuat user group'
        ]);
    }

    public function update(Request $request)
    {
        $permission = Permission::get();
        if (!$permission->has_edit) {
            return response()->json([
                'status' => 'error',
                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
            ]);
        }

        $rules = [
            'id' => 'required|integer',
            'jabatan' => 'required|integer',
            'unit_kerja' => 'required|integer',
            'type' => 'required|in:PEMOHON,OPERATOR'
        ];

        $errorRules = [
            'id.required' => 'data invalid, silahkan refresh halaman dan coba lagi',
            'id.integer' => 'data invalid, silahkan refresh halaman dan coba lagi',
            'jabatan.required' => 'Jabatan harus dipilih',
            'jabatan.integer' => 'Jabatan tidak valid',
            'unit_kerja.required' => 'Unit Kerja harus dipilih',
            'unit_kerja.integer' => 'Unit Kerja tidak valid',
            'type.required' => 'Tipe User Group harus dipilih',
            'type.in' => 'Tipe User Group Tidak Valid'
        ];


        $validator = Validator::make($request->all(), $rules, $errorRules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => $validator->messages()->first()
            ]);
        }

        if ($request->privilege) {
            json_encode($request->privilege);

            if (json_last_error() != JSON_ERROR_NONE) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'bad request'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'bad request'
            ]);
        }

        // CHECK DATA IS EXIST
        $data = UserGroup::where('status', 1)->where('id_user_group', $request->id)->first();
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Data tidak ditemukan, silahkan refresh halaman dan coba lagi'
            ]);
        }

        // CHECK DATA JABATAN AND UNIT_KERJA ALREADY EXIST
        $is_exist = UserGroup::where('status', 1)->where('id_unit_kerja', $request->unit_kerja)->where('id_jabatan', $request->jabatan)->where('id_user_group', '<>', $request->id)->first();
        if ($is_exist) {
            return response()->json([
                'status' => 'error',
                'msg' => 'User Group sudah terdaftar'
            ]);
        }

        $data->id_jabatan = $request->jabatan;
        $data->id_unit_kerja = $request->unit_kerja;
        $data->type = $request->type;
        $data->updated_by = Session::get('id_user');

        if (!$data->save()) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Terjadi kesalahan pada database'
            ]);
        }

        if ($request->privilege) {
            // DELETE ALL DATA USER GROUP PRIVILEGES
            UserGroupPrivilege::where('id_user_group', $data->id_user_group)->delete();

            foreach ($request->privilege as $priv) {
                $UGP = new UserGroupPrivilege();
                $UGP->id_user_group = $data->id_user_group;
                $UGP->id_menu = $priv['id_menu'];
                $UGP->has_view = $priv['has_view'];
                $UGP->has_create = $priv['has_create'];
                $UGP->has_edit = $priv['has_edit'];
                $UGP->has_download = $priv['has_download'];
                $UGP->has_delete = $priv['has_delete'];
                $UGP->created_by = Session::get('id');
                $UGP->save();
            }
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'Berhasil memperbarui user group'
        ]);
    }

    public function delete(Request $request)
    {
        $permission = Permission::get();
        if (!$permission->has_delete) {
            return response()->json([
                'status' => 'error',
                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
            ]);
        }

        if ($request->id) {
            $UK = UserGroup::find($request->id);
            if ($UK) {
                $UK->status = 0;
                $UK->updated_by = Session::get('id_user');

                if ($UK->save()) {
                    return response()->json([
                        'status' => 'success',
                        'msg' => 'berhasil menghapus data'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'msg' => 'terjadi kesalahan pada database, silahkan coba lagi'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'data tidak ditemukan, silahkan refresh halaman dan coba lagi'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'bad request'
            ]);
        }
    }

    # SSO INTEGRATION FUNCTION START
    // GET USER GROUP
    function getUserGroup(Request $request)
    {
        if (!$request->token && $request->token !== env('SSO_API_KEY')) {
            return response()->json([
                'code' => 400,
                'status' => 'bad request',
                'msg' => 'missing parameter'
            ]);
        }

        $user_groups = [];
        // GET ALL USER GROUP START
        $user_groups_all = UserGroup::where('user_groups.status', '=', 1)
            ->join('unit_kerja', 'unit_kerja.id_unit_kerja', '=', 'user_groups.id_unit_kerja')
            ->join('jabatan', 'jabatan.id_jabatan', '=', 'user_groups.id_jabatan')
            ->select('user_groups.id_user_group', 'unit_kerja.name as nama_unit', 'jabatan.name as nama_jabatan')
            ->orderBy('nama_jabatan', 'ASC')
            ->get();

        foreach ($user_groups_all as $uga) {
            $uga_tmp = [
                'value' => $uga->id_user_group,
            ];

            $label = $uga->nama_jabatan . ' ' . $uga->nama_unit;
            if ($uga->nama_unit == 'Umum') {
                $label = $uga->nama_jabatan;
            }
            $uga_tmp['label'] = $label;
            array_push($user_groups, $uga_tmp);
        }

        $data = [
            'list' => $user_groups,
            'value' => null
        ];

        // GET DETAIL USER FROM USERNAME NRK
        if ($request->username) {
            $detail_user = Users::where('nrk', $request->username)->first();
            // IF NOT FOUND FIND WITH EMAIL
            if (!$detail_user) {
                $detail_user = Users::where('email', $request->username)->first();
            }

            if ($detail_user) {
                $data['value'] = $detail_user->id_user_group;
            }
        }

        return response()->json([
            'status' => 'success',
            'payload' => $data
        ]);
    }
    // GET ALL USER GROUP END
    # SSO INTEGRATION FUNCTION END
}
