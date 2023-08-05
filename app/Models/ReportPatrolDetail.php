<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ReportPatrolDetail
 *
 * @property int $id_report_patrol_detail
 * @property int|null $id_company
 * @property int|null $id_report_patrol
 * @property int|null $parent_level
 * @property int|null $patrol_object_id
 * @property bool $is_normal
 * @property string $patrol_note
 * @property bool $is_accident_report
 * @property bool $report_ga
 * @property bool $quick_action
 * @property string|null $quick_action_note
 * @property string $sync_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MasterCompany|null $company
 * @property-read DetailPatrolConfig|null $object
 * @property-read DetailPatrolConfig|null $objectParent
 * @property-read Collection<int, ReportPatrol> $reportPatrol
 * @property-read int|null $report_patrol_count
 * @method static Builder|ReportPatrolDetail newModelQuery()
 * @method static Builder|ReportPatrolDetail newQuery()
 * @method static Builder|ReportPatrolDetail query()
 * @method static Builder|ReportPatrolDetail whereCreatedAt($value)
 * @method static Builder|ReportPatrolDetail whereIdCompany($value)
 * @method static Builder|ReportPatrolDetail whereIdReportPatrol($value)
 * @method static Builder|ReportPatrolDetail whereIdReportPatrolDetail($value)
 * @method static Builder|ReportPatrolDetail whereIsAccidentReport($value)
 * @method static Builder|ReportPatrolDetail whereIsNormal($value)
 * @method static Builder|ReportPatrolDetail whereParentLevel($value)
 * @method static Builder|ReportPatrolDetail wherePatrolNote($value)
 * @method static Builder|ReportPatrolDetail wherePatrolObjectId($value)
 * @method static Builder|ReportPatrolDetail whereQuickAction($value)
 * @method static Builder|ReportPatrolDetail whereQuickActionNote($value)
 * @method static Builder|ReportPatrolDetail whereReportGa($value)
 * @method static Builder|ReportPatrolDetail whereSyncToken($value)
 * @method static Builder|ReportPatrolDetail whereUpdatedAt($value)
 * @property-read Collection<int, ReportPatrolFiles> $files
 * @property-read int|null $files_count
 * @method static Builder|ReportPatrolDetail whereDateBetween($fieldName, $fromDate, $toDate)
 * @property bool $action_status
 * @property string|null $action_note
 * @property string|null $action_proof
 * @property string|null $action_at
 * @property string $action_reported_at
 * @property int|null $action_user
 * @property-read Users|null $actionUser
 * @method static Builder|ReportPatrolDetail whereActionAt($value)
 * @method static Builder|ReportPatrolDetail whereActionNote($value)
 * @method static Builder|ReportPatrolDetail whereActionProof($value)
 * @method static Builder|ReportPatrolDetail whereActionReportedAt($value)
 * @method static Builder|ReportPatrolDetail whereActionStatus($value)
 * @method static Builder|ReportPatrolDetail whereActionUser($value)
 * @mixin Eloquent
 */
class ReportPatrolDetail extends Model
{
    use HasFactory;

    /**
     * Scope a query to only include the last n days records
     *
     * @param Builder $query
     * @param $fieldName
     * @param $fromDate
     * @param $toDate
     * @return Builder
     */
    public function scopeWhereDateBetween(Builder $query, $fieldName, $fromDate, $toDate): Builder
    {
        return $query->whereDate($fieldName, '>=', $fromDate)->whereDate($fieldName, '<=', $toDate);
    }

    protected $casts = [
        'is_normal' => 'boolean',
        'is_accident_report' => 'boolean'
    ];
    protected $table = 'report_patrol_detail';
    protected $primaryKey = 'id_report_patrol_detail';
    protected $fillable = [
        'id_company',
        'id_report_patrol',
        'parent_level',
        'patrol_object_id',
        'is_normal',
        'description',
        'is_accident_report',
        'report_ga',
        'quick_action',
        'quick_action_note',
        'sync_token',
        'created_at',
        'updated_at',
        'action_status',
        'action_note',
        'action_proof',
        'action_user',
        'created_at',
        'updated_at'
    ];

    public function reportPatrol(): BelongsTo
    {
        return $this->belongsTo(ReportPatrol::class, 'id_report_patrol', 'id_report_patrol');
    }

    public function files(): hasMany
    {
        return $this->hasMany(ReportPatrolFiles::class, 'id_report_patrol_detail', 'id_report_patrol_detail');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(MasterCompany::class, 'id_company', 'id_company');
    }

    public function object(): BelongsTo
    {
        return $this->belongsTo(DetailPatrolConfig::class, 'patrol_object_id', 'id_detail_patrol_config');
    }

    public function objectParent(): BelongsTo
    {
        return $this->belongsTo(DetailPatrolConfig::class, 'parent_level', 'id_detail_patrol_config');
    }

    public function action_user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'action_user', 'id_user');
    }


}
