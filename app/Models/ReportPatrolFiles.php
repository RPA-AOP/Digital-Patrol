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
 * App\Models\ReportPatrolFiles
 *
 * @property int $id_report_patrol_files
 * @property int|null $id_report_patrol_detail
 * @property int|null $id_company
 * @property string $thumb
 * @property string $type
 * @property string $path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MasterCompany|null $company
 * @property-read Collection<int, ReportPatrolDetail> $reportPatrolDetail
 * @property-read int|null $report_patrol_detail_count
 * @method static Builder|ReportPatrolFiles newModelQuery()
 * @method static Builder|ReportPatrolFiles newQuery()
 * @method static Builder|ReportPatrolFiles query()
 * @method static Builder|ReportPatrolFiles whereCreatedAt($value)
 * @method static Builder|ReportPatrolFiles whereIdCompany($value)
 * @method static Builder|ReportPatrolFiles whereIdReportPatrolDetail($value)
 * @method static Builder|ReportPatrolFiles whereIdReportPatrolFiles($value)
 * @method static Builder|ReportPatrolFiles wherePath($value)
 * @method static Builder|ReportPatrolFiles whereThumb($value)
 * @method static Builder|ReportPatrolFiles whereType($value)
 * @method static Builder|ReportPatrolFiles whereUpdatedAt($value)
 * @property-read Collection<int, \App\Models\ReportPatrolDetail> $reportPatrolDetail
 * @method static Builder|ReportPatrolFiles whereDateBetween($fieldName, $fromDate, $toDate)
 * @mixin Eloquent
 */
class ReportPatrolFiles extends Model
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

    protected $table = 'report_patroli_files';
    protected $primaryKey = 'id_report_patrol_files';
    protected $fillable = [
        'id_company',
        'id_report_patrol_detail',
        'thumb',
        'type',
        'path',
        'created_at',
        'updated_at',
    ];

    public function reportPatrolDetail(): HasMany
    {
        return $this->hasMany(ReportPatrolDetail::class, 'id_report_patrol_detail', 'id_report_patrol_detail');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(MasterCompany::class, 'id_company', 'id_company');
    }
}
