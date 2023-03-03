<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereIdCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereIdCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereKodeCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereNamaCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereCategoryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MasterCategory whereCategoryName($value)
 * @mixin \Eloquent
 */
class MasterCategory extends Model
{
    use HasFactory;

    protected $table = 'master_category';
    protected $primaryKey = 'id_category';
    protected $fillable = [
        'id_company',
        'category_code',
        'category_name',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
