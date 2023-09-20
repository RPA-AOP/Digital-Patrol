<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\UserGroupPrivilege
 *
 * @property int $id_user_group_privilege
 * @property int|null $id_user_group
 * @property int|null $id_menu
 * @property int $has_view
 * @property int $has_create
 * @property int $has_edit
 * @property int $has_download
 * @property int $has_delete
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Menus|null $menu
 * @property-read Users|null $userCreated
 * @property-read Users|null $userUpdated
 * @method static Builder|UserGroupPrivilege newModelQuery()
 * @method static Builder|UserGroupPrivilege newQuery()
 * @method static Builder|UserGroupPrivilege query()
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @mixin Eloquent
 */
class UserGroupPrivilege extends Model
{ use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

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
