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
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\ReportPatrol
 *
 * @property int $id_report_patrol
 * @property int|null $id_patrol_activity
 * @property int|null $id_company
 * @property int|null $patrol_schedule_shift_id
 * @property int|null $level_1
 * @property int|null $level_2
 * @property int|null $level_3
 * @property int|null $level_4
 * @property string $checkin_time
 * @property string $checkout_time
 * @property bool $status
 * @property string $sync_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MasterCompany|null $company
 * @property-read DetailPatrolConfig|null $level1
 * @property-read DetailPatrolConfig|null $level2
 * @property-read DetailPatrolConfig|null $level3
 * @property-read DetailPatrolConfig|null $level4
 * @property-read PatrolScheduleShift|null $patrolShift
 * @property-read int|null $report_patrol_detail_count
 * @property-read Users $user
 * @method static Builder|ReportPatrol newModelQuery()
 * @method static Builder|ReportPatrol newQuery()
 * @method static Builder|ReportPatrol query()
 * @method static Builder|ReportPatrol whereCheckinTime($value)
 * @method static Builder|ReportPatrol whereCheckoutTime($value)
 * @method static Builder|ReportPatrol whereCreatedAt($value)
 * @method static Builder|ReportPatrol whereIdCompany($value)
 * @method static Builder|ReportPatrol whereIdPatrolActivity($value)
 * @method static Builder|ReportPatrol whereIdReportPatrol($value)
 * @method static Builder|ReportPatrol whereLevel1($value)
 * @method static Builder|ReportPatrol whereLevel2($value)
 * @method static Builder|ReportPatrol whereLevel3($value)
 * @method static Builder|ReportPatrol whereLevel4($value)
 * @method static Builder|ReportPatrol wherePatrolScheduleShiftId($value)
 * @method static Builder|ReportPatrol whereStatus($value)
 * @method static Builder|ReportPatrol whereSyncToken($value)
 * @method static Builder|ReportPatrol whereUpdatedAt($value)
 * @property-read Collection<int, ReportPatrolDetail> $reportPatrolDetail
 * @property int|null $area_id
 * @property-read \App\Models\DetailPatrolConfig|null $area
 * @property-read Collection<int, \App\Models\ReportPatrolDetail> $reportPatrolDetail
 * @method static Builder|ReportPatrol whereAreaId($value)
 * @property-read Collection<int, \App\Models\ReportPatrolDetail> $reportPatrolDetail
 * @method static Builder|ReportPatrol whereDateBetween($fieldName, $fromDate, $toDate)
 * @property-read Collection<int, \App\Models\ReportPatrolDetail> $reportPatrolDetail
 * @property-read Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\PatrolActivity|null $activity
 * @property-read Collection<int, \App\Models\ReportPatrolDetail> $reportPatrolDetail
 * @mixin Eloquent
 */
class ReportPatrol extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

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
        return $query->whereDate($fieldName,'>=',$fromDate)->whereDate($fieldName,'<=',$toDate);
    }

    protected $casts = ['status' => 'boolean'];
    protected $table = 'report_patrol';
    protected $primaryKey = 'id_report_patrol';
    protected $fillable = [
        'id_patrol_activity',
        'id_company',
        'patrol_schedule_shift_id',
        'area_id',
        'checkin_time',
        'checkout_time',
        'sync_token',
        'status',
        'created_at',
        'updated_at',
    ];

    public function reportPatrolDetail(): HasMany
    {
        return $this->hasMany(ReportPatrolDetail::class, 'id_report_patrol', 'id_report_patrol');
    }

    public function patrolShift(): BelongsTo
    {
        return $this->belongsTo(PatrolScheduleShift::class, 'patrol_schedule_shift_id', 'patrol_schedule_shift_id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(PatrolActivity::class, 'id_patrol_activity', 'id_patrol_activity');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(MasterCompany::class, 'id_company', 'id_company');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(DetailPatrolConfig::class, 'id_area',
            'id_detail_patrol_config');
    }

}
