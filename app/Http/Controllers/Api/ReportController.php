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


/**
 * @property Authenticatable|null $user
 */
class ReportController extends BaseApiController
{
    public function postReportAccident(Request $request): JsonResponse
    {
        $data = ReportAccident::create([
            'created_by' => $this->user->id_user,
            'company' => $this->user->id_company,
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
                $data['image_2'] = $this->uploadAttachment($file, $data['report_accident_id']);
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
                $report['detail_temuan'][] = $detail;

            }
        }

        return response()->json($report);
    }
}


//{
//  "detail_temuan": {
//    "2": {
//      "quick_action_note": "null",
//      "quick_action": "0",
//      "is_accident_report": "0",
//      "report_ga": "0",
//      "id_report_patrol": "18",
//      "patrol_note": "null",
//      "parent_level": "15",
//      "is_normal": "1",
//      "sync_token": "3238057b-1f8f-424a-bfe9-a16cfa650899-1679859063465",
//      "status": "1",
//      "conditions": "0",
//      "created_at": "2023-03-27 02:31:03"
//    },
//    "3": {
//      "status": "1",
//      "sync_token": "1063e6ac-f8ee-4672-9b87-b6170573426d-1679859143871",
//      "report_ga": "0",
//      "id_report_patrol": "19",
//      "quick_action": "0",
//      "is_accident_report": "0",
//      "is_normal": "1",
//      "patrol_note": "null",
//      "quick_action_note": "null",
//      "created_at": "2023-03-27 02:32:23",
//      "conditions": "0",
//      "parent_level": "15"
//    },
//    "0": {
//      "status": "1",
//      "quick_action": "0",
//      "id_report_patrol": "16",
//      "is_normal": "1",
//      "quick_action_note": "null",
//      "sync_token": "4bb6abb0-52ad-4ee6-9d86-05f4f1e54772-1679858822630",
//      "is_accident_report": "0",
//      "parent_level": "15",
//      "report_ga": "0",
//      "conditions": "0",
//      "created_at": "2023-03-27 02:27:02",
//      "patrol_note": "null"
//    },
//    "1": {
//      "parent_level": "15",
//      "quick_action_note": "null",
//      "patrol_note": "null",
//      "report_ga": "0",
//      "id_report_patrol": "17",
//      "sync_token": "9a9366c1-494b-48d5-865b-e3dedc0412f1-1679858937000",
//      "is_normal": "1",
//      "quick_action": "0",
//      "created_at": "2023-03-27 02:28:56",
//      "conditions": "0",
//      "is_accident_report": "0",
//      "status": "1"
//    },
//    "4": {
//      "report_ga": "0",
//      "quick_action": "0",
//      "status": "1",
//      "is_normal": "1",
//      "id_report_patrol": "20",
//      "quick_action_note": "null",
//      "sync_token": "42536581-21c5-458a-9d94-c120c556594e-1679859173036",
//      "is_accident_report": "0",
//      "parent_level": "15",
//      "conditions": "0",
//      "created_at": "2023-03-27 02:32:53",
//      "patrol_note": "null"
//    }
//  },
//  "sync_token": "28b7e625-e1e5-4c76-85a4-2422d617f140-1679858820031",
//  "area_id": "15",
//  "checkin_time": "2023-03-27 02:27:00",
//  "status": "1",
//  "created_at": "2023-03-27 02:27:00",
//  "patrol_schedule_shift_id": "1",
//  "id_patrol_activity": "null",
//  "checkout_time": "null"
//}
