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
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

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
 * @property-read MasterCompany $company
 * @property-read Collection<int, DetailPatrolConfig> $patrolDetail
 * @property-read int|null $patrol_detail_count
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
 * @property bool $random_checkpoint
 * @property int $random_checkpoint_percentage
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @method static Builder|PatrolConfig whereRandomCheckpoint($value)
 * @method static Builder|PatrolConfig whereRandomCheckpointPercentage($value)
 * @mixin Eloquent
 */
class PatrolConfig extends Model
{
    use HasFactory;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }


    protected $casts = ['status' => 'boolean'];
    protected $table = 'patrol_config';
    protected $primaryKey = 'id_patrol_config';
    protected $fillable = [
        'id_company',
        'random_checkpoint',
        'random_checkpoint_percentage',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
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
