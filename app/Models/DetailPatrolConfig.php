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
 * App\Models\DetailPatrolConfig
 *
 * @property int $id_detail_patrol_config
 * @property int $id_company
 * @property int $id_patrol_config
 * @property string $code
 * @property string $name
 * @property int $level
 * @property string|null $level_name
 * @property int|null $parent_id
 * @property int|null $category_id
 * @property string|null $identification_key
 * @property string $status
 * @property int $last_level
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read MasterCategory|null $category
 * @property-read Collection<int, DetailPatrolConfig> $child
 * @property-read int|null $child_count
 * @property-read DetailPatrolConfig|null $parent
 * @method static Builder|DetailPatrolConfig newModelQuery()
 * @method static Builder|DetailPatrolConfig newQuery()
 * @method static Builder|DetailPatrolConfig query()
 * @method static Builder|DetailPatrolConfig whereCategoryId($value)
 * @method static Builder|DetailPatrolConfig whereCode($value)
 * @method static Builder|DetailPatrolConfig whereCreatedAt($value)
 * @method static Builder|DetailPatrolConfig whereCreatedBy($value)
 * @method static Builder|DetailPatrolConfig whereIdCompany($value)
 * @method static Builder|DetailPatrolConfig whereIdDetailPatrolConfig($value)
 * @method static Builder|DetailPatrolConfig whereIdPatrolConfig($value)
 * @method static Builder|DetailPatrolConfig whereIdentificationKey($value)
 * @method static Builder|DetailPatrolConfig whereLastLevel($value)
 * @method static Builder|DetailPatrolConfig whereLevel($value)
 * @method static Builder|DetailPatrolConfig whereLevelName($value)
 * @method static Builder|DetailPatrolConfig whereName($value)
 * @method static Builder|DetailPatrolConfig whereParentId($value)
 * @method static Builder|DetailPatrolConfig whereStatus($value)
 * @method static Builder|DetailPatrolConfig whereUpdatedAt($value)
 * @method static Builder|DetailPatrolConfig whereUpdatedBy($value)
 * @property-read Collection<int, DetailPatrolConfig> $child
 * @property-read Collection<int, \App\Models\MasterCategoryAbnormalEvent> $event
 * @property-read int|null $event_count
 * @property-read Collection<int, DetailPatrolConfig> $child
 * @property-read Collection<int, \App\Models\MasterCategoryAbnormalEvent> $event
 * @mixin Eloquent
 */
class DetailPatrolConfig extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => 'boolean',
        'last_level' => 'boolean',
    ];
    protected $table = 'detail_patrol_config';
    protected $primaryKey = 'id_detail_patrol_config';
    protected $fillable = [
        'id_company',
        'id_patrol_config',
        'code',
        'name',
        'level',
        'parent_id',
        'category_id',
        'identification_key',
        'status',
        'last_level',
        'created_by',
        'updated_by'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(DetailPatrolConfig::class, 'id_detail_patrol_config', 'parent_id');
    }

    public function child(): HasMany
    {
        return $this->hasMany(DetailPatrolConfig::class, 'parent_id', 'id_detail_patrol_config');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MasterCategory::class, 'category_id', 'id_category');
    }

    public function event(): HasMany
    {
        return $this->hasMany(MasterCategoryAbnormalEvent::class, 'id_category', 'category_id');
    }
}
