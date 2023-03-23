<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserGroup
 *
 * @property int $id_user_group
 * @property string $name
 * @property int|null $sort
 * @property int $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, UserGroupPrivilege> $privilages
 * @property-read int|null $privilages_count
 * @property-read Users|null $user_created
 * @property-read Users|null $user_updated
 * @method static Builder|UserGroup newModelQuery()
 * @method static Builder|UserGroup newQuery()
 * @method static Builder|UserGroup query()
 * @method static Builder|UserGroup whereCreatedAt($value)
 * @method static Builder|UserGroup whereCreatedBy($value)
 * @method static Builder|UserGroup whereIdUserGroup($value)
 * @method static Builder|UserGroup whereName($value)
 * @method static Builder|UserGroup whereSort($value)
 * @method static Builder|UserGroup whereStatus($value)
 * @method static Builder|UserGroup whereUpdatedAt($value)
 * @method static Builder|UserGroup whereUpdatedBy($value)
 * @property-read Collection<int, \App\Models\UserGroupPrivilege> $privilages
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
