<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\PatrolScheduleDetailConfig
 *
 * @property int $patrol_schedule_detail
 * @property int|null $patrol_schedule_id
 * @property int|null $patrol_schedule_shift_id
 * @property int|null $id_user
 * @property string $patrol_date
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read PatrolScheduleShift|null $patrolShift
 * @method static Builder|PatrolScheduleDetailConfig newModelQuery()
 * @method static Builder|PatrolScheduleDetailConfig newQuery()
 * @method static Builder|PatrolScheduleDetailConfig query()
 * @method static Builder|PatrolScheduleDetailConfig whereCreatedAt($value)
 * @method static Builder|PatrolScheduleDetailConfig whereIdUser($value)
 * @method static Builder|PatrolScheduleDetailConfig wherePatrolDate($value)
 * @method static Builder|PatrolScheduleDetailConfig wherePatrolScheduleDetail($value)
 * @method static Builder|PatrolScheduleDetailConfig wherePatrolScheduleId($value)
 * @method static Builder|PatrolScheduleDetailConfig wherePatrolScheduleShiftId($value)
 * @method static Builder|PatrolScheduleDetailConfig whereStatus($value)
 * @method static Builder|PatrolScheduleDetailConfig whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @mixin Eloquent
 */
class PatrolScheduleDetailConfig extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }


    protected $casts = ['status' => 'boolean'];
    protected $table = 'patrol_schedule_detail';
    protected $primaryKey = 'patrol_schedule_detail';
    protected $fillable = [
        'patrol_schedule_id',
        'patrol_schedule_shift_id',
        'id_user',
        'patrol_date',
        'status',
        'created_by',
        'updated_by'
    ];

  public function patrolShift(): BelongsTo
  {
    return $this->belongsTo(PatrolScheduleShift::class, 'patrol_schedule_shift_id', 'patrol_schedule_shift_id');
  }
}
