<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MasterCategory
 *
 * @property int $id_category
 * @property int $id_company
 * @property string|null $category_code
 * @property string|null $category_name
 * @property bool $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|MasterCategory newModelQuery()
 * @method static Builder|MasterCategory newQuery()
 * @method static Builder|MasterCategory query()
 * @method static Builder|MasterCategory whereCreatedAt($value)
 * @method static Builder|MasterCategory whereCreatedBy($value)
 * @method static Builder|MasterCategory whereIdCategory($value)
 * @method static Builder|MasterCategory whereIdCompany($value)
 * @method static Builder|MasterCategory whereKodeCategory($value)
 * @method static Builder|MasterCategory whereNamaCategory($value)
 * @method static Builder|MasterCategory whereStatus($value)
 * @method static Builder|MasterCategory whereUpdatedAt($value)
 * @method static Builder|MasterCategory whereUpdatedBy($value)
 * @method static Builder|MasterCategory whereCategoryCode($value)
 * @method static Builder|MasterCategory whereCategoryName($value)
 * @mixin Eloquent
 */
class MasterCategoryAbnormalEvent extends Model
{
    use HasFactory;

    protected $table = 'master_category_event';
    protected $primaryKey = 'id_category_event';
    protected $fillable = [
        'id_category',
        'id_company',
        'category_event',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
