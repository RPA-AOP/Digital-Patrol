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
 * App\Models\PatrolScheduleConfig
 *
 * @property int $patrol_schedule_id
 * @property int|null $id_company
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MasterCompany|null $company
 * @property-read Collection<int, DetailPatrolConfig> $patrolDetail
 * @property-read int|null $patrol_detail_count
 * @method static Builder|PatrolScheduleConfig newModelQuery()
 * @method static Builder|PatrolScheduleConfig newQuery()
 * @method static Builder|PatrolScheduleConfig query()
 * @method static Builder|PatrolScheduleConfig whereCreatedAt($value)
 * @method static Builder|PatrolScheduleConfig whereIdCompany($value)
 * @method static Builder|PatrolScheduleConfig wherePatrolScheduleId($value)
 * @method static Builder|PatrolScheduleConfig whereStatus($value)
 * @method static Builder|PatrolScheduleConfig whereUpdatedAt($value)
 * @property-read Collection<int, \App\Models\DetailPatrolConfig> $patrolDetail
 * @property-read Collection<int, \App\Models\DetailPatrolConfig> $patrolDetail
 * @mixin Eloquent
 */
class PatrolScheduleConfig extends Model
{
    use HasFactory;

    protected $casts = ['status' => 'boolean'];
    protected $table = 'patrol_schedule';
    protected $primaryKey = 'patrol_schedule_id';
    protected $fillable = [
        'id_company',
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
}
