<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserGroup
 *
 * @method static Builder|UserGroup newModelQuery()
 * @method static Builder|UserGroup newQuery()
 * @method static Builder|UserGroup query()
 * @property-read Jabatan $jabatan
 * @property-read UnitKerja $unitKerja
 * @property-read Users $user_created
 * @property-read Users $user_updated
 * @property int $id_user_group
 * @property int $id_jabatan
 * @property int $id_unit_kerja
 * @property string $type
 * @property int|null $sort
 * @property int $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserGroupPrivilege[] $privilages
 * @property-read int|null $privilages_count
 * @method static Builder|UserGroup whereCreatedAt($value)
 * @method static Builder|UserGroup whereCreatedBy($value)
 * @method static Builder|UserGroup whereIdJabatan($value)
 * @method static Builder|UserGroup whereIdUnitKerja($value)
 * @method static Builder|UserGroup whereIdUserGroup($value)
 * @method static Builder|UserGroup whereSort($value)
 * @method static Builder|UserGroup whereStatus($value)
 * @method static Builder|UserGroup whereType($value)
 * @method static Builder|UserGroup whereUpdatedAt($value)
 * @method static Builder|UserGroup whereUpdatedBy($value)
 * @property string $name
 * @method static Builder|UserGroup whereName($value)
 * @mixin Eloquent
 */
class UserGroup extends Model
{
    protected $table = 'user_groups';
    protected $primaryKey = 'id_user_group';
    protected $fillable = [
        'name',
        'sort',
        'status',
        'created_by',
        'updated_by',
    ];


    public function user_created()
    {
        return $this->belongsTo(Users::class, 'created_by', 'id_user');
    }
    public function user_updated()
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id_user');
    }

    public function privilages()
    {
        return $this->hasMany(UserGroupPrivilege::class, 'id_user_group', 'id_user_group');
    }
}
