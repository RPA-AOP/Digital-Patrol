<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use App\Helpers\UploadFile;
use App\Imports\ImportPatrolConfig;
use App\Models\DetailPatrolConfig;
use App\Models\MasterCategory;
use App\Models\MasterCompany;
use App\Models\PatrolConfig;
use App\Models\UserGroup;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PatrolConfigController extends Controller
{

    public function index(): View|Factory|Application|RedirectResponse
    {
        $permission = Permission::get();
        if ($permission->has_view) {
            $data = ['permission' => $permission];
            return \Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY ? redirect()->route('patrolconfig.manage', ['id' => \Auth::user()->id_company]) : view('modules.builder.index', $data);
        } else {
            abort(403, 'Anda tidak memiliki akses pada menu ini');
        }
    }

    public function list(Request $request)
    {

    }

    public function create(): Factory|View|Application
    {
        return view('modules.builder.create');

    }

    public function manage($id): Factory|View|Application
    {
        if (\Auth::user()->id_user_group == UserGroup::ADMIN_COMPANY) {
            $company = MasterCompany::where('id_company', \Auth::user()->id_company)->first();
        } else {
            $company = MasterCompany::where('id_company', $id)->first();
        }
        $patrolConfigExist = PatrolConfig::where('id_company', $id)->exists();
        if (!$patrolConfigExist){
            $patrolConfig = PatrolConfig::create([
                'id_company' => $id,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }
        $dataConfig = PatrolConfig::with('company')->with(["patrolDetail" => function ($q) use ($id) {
            $q->where('level', '=', 1)->where('id_company', $id);
        }])->where('id_company', $id)->first();

        $itemLevel = null;
        $parentItem = null;
        if ($dataConfig) {
            $itemLevel = DetailPatrolConfig::where('id_patrol_config', $dataConfig->id_patrol_config)
                ->whereNotNull('level_name')
                ->select(['level', 'level_name'])->distinct()
                ->get()
                ->toArray();

            $parentItem = DetailPatrolConfig::where('id_patrol_config', $dataConfig->id_patrol_config)
                ->where('level', '<', 5)
                ->select(['id_detail_patrol_config', 'name'])
                ->orderBy('level')
                ->get()
                ->toArray();
        }

        $category = MasterCategory::where('id_company', $id)
            ->get(['category_name', 'id_category']);
        \Cache::flush();
        return view('modules.builder.manage', compact('dataConfig', 'category', 'company', 'itemLevel', 'parentItem'));

    }

    public function import(Request $request)
    {
        $maxfilesize = config('app.max_file_size_upload') * 1024;
        $request->validate([
            'import-data-patroli' => "required|mimes:xlsx,xls|max:{$maxfilesize}",
        ]);

        $idCompany = $request->get('idCompany');
        $patrolConfig = PatrolConfig::where('id_company', $idCompany)->first();
        $files = $request->file('import-data-patroli');
        if ($files) {
            if (!$patrolConfig) {
                $patrolConfig = PatrolConfig::create([
                    'id_company' => $idCompany,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
                $patrolConfig->save();
            }
            $filePath = UploadFile::uploadSingle($files);
            if ($filePath) {
                Excel::import(new ImportPatrolConfig($idCompany, $patrolConfig->id_patrol_config), $filePath);
                return redirect()->route('patrolconfig.manage', $idCompany)->with('success', 'Import Success.');
            } else {
                return redirect()->back(501)->with('error', 'upload failed, ');
            }
        }
        return redirect()->route('patrolconfig.manage', $idCompany);
    }

    public function store(Request $request)
    {

    }

    public function updateConfig(Request $request, $id)
    {
        $permission = Permission::get();
        if ($permission->has_edit) {
            $request->validate([
                'random_checkpoint_percentage' => 'numeric|min:20|max:100',
            ]);
            $config = PatrolConfig::find($id);
            $config->random_checkpoint = (bool)$request->post('random_checkpoint',);
            $config->random_checkpoint_percentage = $request->post('random_checkpoint_percentage', 80);
            if ($config->save()) {
                return redirect()->route('patrolconfig.manage', ['id'=> $id])
                    ->with('success', 'Config Berhasil Di Update');
            }
            return redirect()->route('patrolconfig.manage', ['id'=> $id])
                ->with('error', 'Config Gagal Di Update');
        }
    }

    public function update(Request $request, $id)
    {
        $idDetailCOnfig = $request->post('id_detail_patrol_config');
        $detailConfig = DetailPatrolConfig::find($idDetailCOnfig);
        $detailConfig->code = $request->code;
        $detailConfig->name = $request->name;
        $detailConfig->parent_id = $request->parent_id;
        $detailConfig->identification_key = $request->identification_key;
        if ($request->post('level_id')) {
            $detailConfig->level = $request->level_id;
        }
        if ($request->post('category_id'))
            $detailConfig->category_id = $request->category_id;
        if ($detailConfig->save()) {
            $detailConfig->refresh();
            return response()->json(['status' => 'updated', 'data' => $detailConfig->toArray()], 200);
        }
        return response()->json(['status' => 'update failed',], 500);
    }

    function updateList($data, $idPatrolConfig, $parent_id = 0): bool
    {
        foreach ($data as $item) {
            try {
                $detailConfig = DetailPatrolConfig::where('id_detail_patrol_config', $item['id'])
                    ->where('id_patrol_config', $idPatrolConfig)->first();
                $detailConfig->parent_id = $parent_id;
                $detailConfig->save();
            } catch (\Exception $e) {
                return false;
            }
            if (array_key_exists("children", $item)) {
                $this->updateList($item['children'], $idPatrolConfig, $item['id']);
            }
        }
        return true;
    }

    public function updateConfigHierarchy(Request $request, $id): JsonResponse
    {
        $patrolConfig = PatrolConfig::where('id_patrol_config', $id)->first();
        if (!$patrolConfig) {
            return response()->json(['status' => 'Update failed, Patrol config not found',], 500);
        }
        $data = json_decode($request->post('data'), true);
        if ($this->updateList($data[0]['children'], $id, $data[0]['id']))
            return response()->json(['status' => 'updated'], 200);
        return response()->json(['status' => 'update failed',], 500);

    }
}
