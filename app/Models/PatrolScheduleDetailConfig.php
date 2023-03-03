<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\DetailPatrolConfig
 *
 * @property int $id_detail_patrol_config
 * @property int $id_company
 * @property int $id_patrol_config
 * @property string $category_name
 * @property string $code
 * @property string $name
 * @property int $level
 * @property int|null $parent_id
 * @property int|null $category_id
 * @property string|null $identification_key
 * @property string $status
 * @property int $last_level
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|DetailPatrolConfig newModelQuery()
 * @method static Builder|DetailPatrolConfig newQuery()
 * @method static Builder|DetailPatrolConfig query()
 * @method static Builder|DetailPatrolConfig whereCategoryId($value)
 * @method static Builder|DetailPatrolConfig whereCategoryName($value)
 * @method static Builder|DetailPatrolConfig whereCode($value)
 * @method static Builder|DetailPatrolConfig whereCreatedAt($value)
 * @method static Builder|DetailPatrolConfig whereCreatedBy($value)
 * @method static Builder|DetailPatrolConfig whereIdCompany($value)
 * @method static Builder|DetailPatrolConfig whereIdDetailPatrolConfig($value)
 * @method static Builder|DetailPatrolConfig whereIdPatrolConfig($value)
 * @method static Builder|DetailPatrolConfig whereIdentificationKey($value)
 * @method static Builder|DetailPatrolConfig whereLastLevel($value)
 * @method static Builder|DetailPatrolConfig whereLevel($value)
 * @method static Builder|DetailPatrolConfig whereName($value)
 * @method static Builder|DetailPatrolConfig whereParentId($value)
 * @method static Builder|DetailPatrolConfig whereStatus($value)
 * @method static Builder|DetailPatrolConfig whereUpdatedAt($value)
 * @method static Builder|DetailPatrolConfig whereUpdatedBy($value)
 * @property string|null $level_name
 * @method static Builder|DetailPatrolConfig whereLevelName($value)
 * @property-read \App\Models\MasterCategory|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection|DetailPatrolConfig[] $child
 * @property-read int|null $child_count
 * @property-read DetailPatrolConfig $parent
 * @property int $patrol_schedule_detail
 * @property int|null $patrol_schedule_id
 * @property int|null $patrol_schedule_shift_id
 * @property int|null $id_user
 * @property string $patrol_date
 * @method static Builder|PatrolScheduleDetailConfig whereIdUser($value)
 * @method static Builder|PatrolScheduleDetailConfig wherePatrolDate($value)
 * @method static Builder|PatrolScheduleDetailConfig wherePatrolScheduleDetail($value)
 * @method static Builder|PatrolScheduleDetailConfig wherePatrolScheduleId($value)
 * @method static Builder|PatrolScheduleDetailConfig wherePatrolScheduleShiftId($value)
 * @mixin Eloquent
 */
class PatrolScheduleDetailConfig extends Model
{
    use HasFactory;

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
