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
 * App\Models\PatrolScheduleShift
 *
 * @property int $patrol_schedule_shift_id
 * @property string $shift_name
 * @property string $shift_code
 * @property string|null $start_hour
 * @property string|null $end_hour
 * @property int|null $id_company
 * @property int|null $area
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MasterCompany|null $company
 * @property-read DetailPatrolConfig|null $patrolArea
 * @property-read Collection<int, DetailPatrolConfig> $patrolDetail
 * @property-read int|null $patrol_detail_count
 * @method static Builder|PatrolScheduleShift newModelQuery()
 * @method static Builder|PatrolScheduleShift newQuery()
 * @method static Builder|PatrolScheduleShift query()
 * @method static Builder|PatrolScheduleShift whereArea($value)
 * @method static Builder|PatrolScheduleShift whereCreatedAt($value)
 * @method static Builder|PatrolScheduleShift whereEndHour($value)
 * @method static Builder|PatrolScheduleShift whereIdCompany($value)
 * @method static Builder|PatrolScheduleShift wherePatrolScheduleShiftId($value)
 * @method static Builder|PatrolScheduleShift whereShiftCode($value)
 * @method static Builder|PatrolScheduleShift whereShiftName($value)
 * @method static Builder|PatrolScheduleShift whereStartHour($value)
 * @method static Builder|PatrolScheduleShift whereStatus($value)
 * @method static Builder|PatrolScheduleShift whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PatrolScheduleShift extends Model
{
    use HasFactory;

    protected $casts = ['status' => 'boolean'];
    protected $table = 'patrol_schedule_shift';
    protected $primaryKey = 'patrol_schedule_shift_id';
    protected $fillable = [
        'id_company',
        'area',
        'shift_name',
        'shift_code',
        'start_hour',
        'end_hour',
        'status',
        'created_at',
        'updated_at',
    ];

    public function patrolDetail(): HasMany
    {
        return $this->hasMany(DetailPatrolConfig::class, 'id_patrol_config', 'id_patrol_config');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(MasterCompany::class, 'id_company', 'id_company');
    }

    public function patrolArea(): BelongsTo
    {
        return $this->belongsTo(DetailPatrolConfig::class, 'area', 'id_detail_patrol_config');
    }
}
