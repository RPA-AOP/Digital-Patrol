<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use App\Models\MasterProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Controller extends Controller
{
    public function master_program(Request $request): JsonResponse
    {
        $keyword = $request->get('search');
        $model = MasterProgram::query()
            ->select('id_program as id', 'nama as name')
            ->where('nama', 'like', '%' . strtolower($keyword) . '%')
            ->orWhere('kode', 'like', '%' . strtolower($keyword) . '%')
            ->limit(10)
            ->get();

        return response()->json($model);
    }

    public function get(Request $request): JsonResponse
    {
        $keyword = $request->get('search');
        $tableName = $request->get('tableName');
        $primaryField = $request->get('primaryField');
        $valueField = $request->get('valueField');
        $searchField = $request->get('searchField');

        $model = DB::query()
            ->select([$primaryField, $valueField])
            ->from($tableName)
            ->where($primaryField, 'like', '%' . strtolower($keyword) . '%')
            ->orWhere($valueField, 'like', '%' . strtolower($keyword) . '%');
        if ($searchField) {
            $model = $model->orWhere($searchField, 'like', '%' . strtolower($keyword) . '%');
        }
        $model = $model->limit(10)->get();

        return response()->json($model);
    }


}
