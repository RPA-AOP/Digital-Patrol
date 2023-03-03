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
 * App\Models\PatrolConfig
 *
 * @property int $id_patrol_config
 * @property int $id_company
 * @property bool $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PatrolConfig newModelQuery()
 * @method static Builder|PatrolConfig newQuery()
 * @method static Builder|PatrolConfig query()
 * @method static Builder|PatrolConfig whereCreatedAt($value)
 * @method static Builder|PatrolConfig whereCreatedBy($value)
 * @method static Builder|PatrolConfig whereIdCompany($value)
 * @method static Builder|PatrolConfig whereIdPatrolConfig($value)
 * @method static Builder|PatrolConfig whereStatus($value)
 * @method static Builder|PatrolConfig whereUpdatedAt($value)
 * @method static Builder|PatrolConfig whereUpdatedBy($value)
 * @property-read MasterCompany $company
 * @property-read Collection|DetailPatrolConfig[] $patrolDetail
 * @property-read int|null $patrol_detail_count
 * @property int $patrol_schedule_id
 * @method static Builder|PatrolScheduleConfig wherePatrolScheduleId($value)
 * @mixin Eloquent
 */
class PatrolScheduleConfig extends Model
{
    use HasFactory;
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
