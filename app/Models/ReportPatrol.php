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

class ReportPatrol extends Model
{
  use HasFactory;

  protected $table = 'report_patrol';
  protected $primaryKey = 'id_report_patrol';
  protected $fillable = [
    'id_company',
    'level_1',
    'level_2',
    'level_3',
    'level_4',
    'id_user',
    'in_shift',
    'checkin_time',
    'checkout_time',
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

  public function user(): BelongsTo
  {
    return $this->belongsTo(Users::class, 'id_user', 'id_user');
  }

  public function company(): BelongsTo
  {
    return $this->belongsTo(MasterCompany::class, 'id_company', 'id_company');
  }

  public function level1(): BelongsTo
  {
    return $this->belongsTo(DetailPatrolConfig::class, 'level_1', 'id_detail_patrol_config');
  }

  public function level2(): BelongsTo
  {
    return $this->belongsTo(DetailPatrolConfig::class, 'level_2', 'id_detail_patrol_config');
  }

  public function level3(): BelongsTo
  {
    return $this->belongsTo(DetailPatrolConfig::class, 'level_3', 'id_detail_patrol_config');
  }

  public function level4(): BelongsTo
  {
    return $this->belongsTo(DetailPatrolConfig::class, 'level_4', 'id_detail_patrol_config');
  }
}
