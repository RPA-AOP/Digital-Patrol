<?php

namespace App\Http\Controllers\Api;

use App\Helpers\UploadFile;
use App\Models\ReportAccident;
use App\Models\ReportAccidentAttachment;
use App\Models\ReportPatrol;
use App\Models\ReportPatrolDetail;
use App\Models\ReportPatrolFiles;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Validator;


/**
 * @property Authenticatable|null $user
 */
class ReportController extends BaseApiController
{
    public function postReportAccident(Request $request): JsonResponse
    {
        $maxfilesize = config('app.max_api_file_size_upload') * 1024;

        $validate = Validator::make($request->all(),
            [
                'title' => 'required|alpha_dash',
                'description' => 'boolean|alpha_dash',
                'image_1' => "max:{$maxfilesize}",
                'image_2' => "max:{$maxfilesize}",
                'image_3' => "max:{$maxfilesize}",
            ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }

        $data = ReportAccident::create([
            'created_by' => $this->user->id_user,
            'id_company' => $this->user->id_company,
            'title' => $request->title,
            'description' => $request->description,
        ]);


        if ($data) {
            $data = $data->refresh()->toArray();
            if ($request->file('image_1')) {
                $file = $request->file('image_1');
                $data['image_1'] = $this->uploadAttachment($file, $data['report_accident_id']);

            }
            if ($request->file('image_2')) {
                $file = $request->file('image_2');
                $data['image_2'] = $this->uploadAttachment($file, $data['report_accident_id']);
            }

            if ($request->file('image_3')) {
                $file = $request->file('image_3');
                $data['image_3'] = $this->uploadAttachment($file, $data['report_accident_id']);
            }
            return response()->json($data);
        }
        return response()->json([], 502);
    }

    function uploadAttachment($file, $relationId, $isReport = false,): ?string
    {
        $path = $isReport ? 'report' : 'accident';
        $filePath = UploadFile::uploadSingle($file, $path);
        if ($filePath)
            if ($isReport) {
                ReportPatrolFiles::updateOrCreate(
                    [
                        'id_report_patrol_detail' => $relationId,
                        'path' => $filePath
                    ],
                    [
                        'id_report_patrol_detail' => $relationId,
                        'id_company' => $this->user->id_company,
                        'type' => $file->getClientOriginalExtension(),
                        'thumb' => $filePath,
                    ]);
            } else {
                ReportAccidentAttachment::updateOrCreate(
                    [
                        'report_accident_id' => $relationId,
                    ],
                    [
                        'report_accident_id' => $relationId,
                        'path' => $filePath,
                        'extension' => $file->getClientOriginalExtension()
                    ]);
            }
        return $filePath;
    }

    public function postReport(Request $request): JsonResponse
    {
        $maxfilesize = config('app.max_api_file_size_upload') * 1024;

        $validate = Validator::make($request->all(),
            [
                'detail_temuan.*.image_1' => "max:{$maxfilesize}",
                'detail_temuan.*.image_2' => "max:{$maxfilesize}",
                'detail_temuan.*.image_3' => "max:{$maxfilesize}",
            ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }
        $dataReport = Arr::except($request->post(), ['detail_temuan']);
        $dataDetail = $request->post('detail_temuan');
        $dataReport = array_filter($dataReport, fn($value) => !is_null($value) && $value !== 'null');

        $dataReport['id_company'] = $this->user->id_company;

        $report = ReportPatrol::updateOrCreate(
            [
                'sync_token' => $dataReport['sync_token']
            ],
            $dataReport
        );


        $report = $report->refresh()->toArray();

        if ($dataDetail) {
            foreach ($dataDetail as $key => $detail) {
                $detail['id_company'] = $this->user->id_company;
                $detail['id_report_patrol'] = $report['id_report_patrol'];
                $detailReport = ReportPatrolDetail::updateOrCreate(['sync_token' => $detail['sync_token']], $detail);
                $detailReport->refresh();
                if ($request->hasFile("detail_temuan.$detailReport->sync_token.image_1")) {
                    $file = $request->file("detail_temuan")[$detailReport->sync_token]['image_1'];
                    $detail['image_1'] = $this->uploadAttachment($file, $detailReport->id_report_patrol_detail, true);
                }
                if ($request->hasFile("detail_temuan.$detailReport->sync_token.image_2")) {
                    $file = $request->file("detail_temuan")[$detailReport->sync_token]['image_2'];
                    $detail['image_2'] = $this->uploadAttachment($file, $detailReport->id_report_patrol_detail, true);
                }
                if ($request->hasFile("detail_temuan.$detailReport->sync_token.image_3")) {
                    $file = $request->file("detail_temuan")[$detailReport->sync_token]['image_3'];
                    $detail['image_3'] = $this->uploadAttachment($file, $detailReport->id_report_patrol_detail, true);
                }

                $existingImage = ReportPatrolFiles::where('id_report_patrol_detail', $detailReport->id_report_patrol_detail)->get();
                foreach ($existingImage as $k => $item) {
                    $detail['image_' . $k + 1] = $item->thumb;
                }
                if ($detailReport->patrol_note = 'null') {
                    $detailReport->patrol_note = null;
                }
                $report['detail_temuan'][] = $detail;

            }
        }

        return response()->json($report);
    }

    public function setAreaDone(Request $request): JsonResponse
    {
        $dataReport = Arr::except($request->post(), ['detail_temuan']);
        $dataReport = array_filter($dataReport, fn($value) => !is_null($value) && $value !== 'null');

        $dataReport['id_company'] = $this->user->id_company;

        $report = ReportPatrol::updateOrCreate(
            [
                'sync_token' => $dataReport['sync_token']
            ],
            $dataReport
        );


        $report = $report->refresh()->toArray();


        return response()->json($report);
    }

    public function preview(Request $request): StreamedResponse|JsonResponse
    {
        $validate = Validator::make($request->all(),
            [
                'path' => "required",
            ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }
        $filePath = $request->get('path');
        if (Storage::exists($filePath)) {
            return Storage::response($filePath);
        }
        return abort(404, "not found");
    }
}

