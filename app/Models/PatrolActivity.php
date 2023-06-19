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
 * App\Models\PatrolActivity
 *
 * @property int $id_patrol_activity
 * @property int|null $id_company
 * @property int|null $patrol_schedule_shift_id
 * @property int|null $id_user
 * @property bool $in_shift
 * @property string $patrol_date
 * @property string $patrol_start_time
 * @property string|null $patrol_end_time
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MasterCompany|null $company
 * @property-read PatrolScheduleShift|null $patrolShift
 * @property-read Collection<int, ReportPatrol> $reportPatrol
 * @property-read int|null $report_patrol_count
 * @property-read Users|null $user
 * @method static Builder|PatrolActivity newModelQuery()
 * @method static Builder|PatrolActivity newQuery()
 * @method static Builder|PatrolActivity query()
 * @method static Builder|PatrolActivity whereCreatedAt($value)
 * @method static Builder|PatrolActivity whereIdCompany($value)
 * @method static Builder|PatrolActivity whereIdPatrolActivity($value)
 * @method static Builder|PatrolActivity whereIdUser($value)
 * @method static Builder|PatrolActivity whereInShift($value)
 * @method static Builder|PatrolActivity wherePatrolDate($value)
 * @method static Builder|PatrolActivity wherePatrolEndTime($value)
 * @method static Builder|PatrolActivity wherePatrolScheduleShiftId($value)
 * @method static Builder|PatrolActivity wherePatrolStartTime($value)
 * @method static Builder|PatrolActivity whereStatus($value)
 * @method static Builder|PatrolActivity whereUpdatedAt($value)
 * @property-read Collection<int, \App\Models\ReportPatrol> $reportPatrol
 * @property-read Collection<int, \App\Models\ReportPatrol> $reportPatrol
 * @mixin Eloquent
 */
class PatrolActivity extends Model
{
  use HasFactory;

  protected $table = 'patrol_activity';
  protected $primaryKey = 'id_patrol_activity';
  protected $fillable = [
    'id_company',
    'patrol_schedule_shift_id',
    'id_user',
    'in_shift',
    'patrol_date',
    'patrol_start_time',
    'patrol_end_time',
    'status',
    'created_at',
    'updated_at',
  ];

  public function reportPatrol(): HasMany
  {
    return $this->hasMany(ReportPatrol::class, 'id_patrol_activity', 'id_patrol_activity');
  }
  public function patrolShift(): BelongsTo
  {
    return $this->belongsTo(PatrolScheduleShift::class, 'patrol_schedule_shift_id', 'patrol_schedule_shift_id');
  }
  public function user(): BelongsTo
  {
    return $this->belongsTo(Users::class, 'id_user', 'id_user');
  }
  public function company(): BelongsTo
  {
    return $this->belongsTo(MasterCompany::class, 'id_company', 'id_company');
  }
}
