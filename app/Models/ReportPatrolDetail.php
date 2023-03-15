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

class ReportPatrolDetail extends Model
{
  use HasFactory;

  protected $table = 'report_patrol_detail';
  protected $primaryKey = 'id_report_patrol_detail';
  protected $fillable = [
    'id_company',
    'id_report_patrol',
    'parent_level',
    'patrol_object_id',
    'is_normal',
    'patrol_note',
    'is_accident_report',
    'report_ga',
    'quick_action',
    'quick_action_note',
    'created_at',
    'updated_at',
  ];

  public function reportPatrol(): HasMany
  {
    return $this->hasMany(ReportPatrol::class, 'id_report_patrol', 'id_report_patrol');
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
}
