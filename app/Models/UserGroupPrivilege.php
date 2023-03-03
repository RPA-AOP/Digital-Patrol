<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserGroupPrivilege
 *
 * @method static Builder|UserGroupPrivilege newModelQuery()
 * @method static Builder|UserGroupPrivilege newQuery()
 * @method static Builder|UserGroupPrivilege query()
 * @property-read \App\Models\Users $userCreated
 * @property-read \App\Models\Users $userUpdated
 * @property int $id_user_group_privilege
 * @property int $id_user_group
 * @property int $id_menu
 * @property int $has_view
 * @property int $has_create
 * @property int $has_edit
 * @property int $has_download
 * @property int $has_delete
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|UserGroupPrivilege whereCreatedAt($value)
 * @method static Builder|UserGroupPrivilege whereCreatedBy($value)
 * @method static Builder|UserGroupPrivilege whereHasCreate($value)
 * @method static Builder|UserGroupPrivilege whereHasDelete($value)
 * @method static Builder|UserGroupPrivilege whereHasDownload($value)
 * @method static Builder|UserGroupPrivilege whereHasEdit($value)
 * @method static Builder|UserGroupPrivilege whereHasView($value)
 * @method static Builder|UserGroupPrivilege whereIdMenu($value)
 * @method static Builder|UserGroupPrivilege whereIdUserGroup($value)
 * @method static Builder|UserGroupPrivilege whereIdUserGroupPrivilege($value)
 * @method static Builder|UserGroupPrivilege whereUpdatedAt($value)
 * @method static Builder|UserGroupPrivilege whereUpdatedBy($value)
 * @property-read \App\Models\Menus|null $menu
 * @mixin Eloquent
 */
class UserGroupPrivilege extends Model
{
    protected $table = 'user_group_privileges';
    protected $primaryKey = 'id_user_group_privilege';
    protected $fillable = [
        'id_user_group',
        'id_menu',
        'has_view',
        'has_create',
        'has_edit',
        'has_download',
        'has_delete',
        'created_by',
        'updated_by'
    ];

    public function userCreated()
    {
        return $this->belongsTo(Users::class, 'created_by', 'id_user');
    }
    public function userUpdated()
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id_user');
    }
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menus::class, 'id_menu', 'id_menu');
    }
}
