<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;


/**
 * App\Models\Users
 *
 * @property int $id_user
 * @property string $username
 * @property string $password
 * @property string $nama
 * @property string|null $email
 * @property string|null $npk
 * @property string|null $image
 * @property int|null $id_company
 * @property int|null $id_user_group
 * @property int $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|\App\Models\UserGroupPrivilege[] $privileges
 * @property-read int|null $privileges_count
 * @property-read Users|null $userCreated
 * @property-read \App\Models\UserGroup|null $userGroup
 * @property-read Users|null $userUpdated
 * @method static Builder|Users newModelQuery()
 * @method static Builder|Users newQuery()
 * @method static Builder|Users query()
 * @method static Builder|Users whereCreatedAt($value)
 * @method static Builder|Users whereCreatedBy($value)
 * @method static Builder|Users whereEmail($value)
 * @method static Builder|Users whereIdCompany($value)
 * @method static Builder|Users whereIdUser($value)
 * @method static Builder|Users whereIdUserGroup($value)
 * @method static Builder|Users whereImage($value)
 * @method static Builder|Users whereNama($value)
 * @method static Builder|Users whereNpk($value)
 * @method static Builder|Users wherePassword($value)
 * @method static Builder|Users whereStatus($value)
 * @method static Builder|Users whereUpdatedAt($value)
 * @method static Builder|Users whereUpdatedBy($value)
 * @method static Builder|Users whereUsername($value)
 * @property string|null $phone
 * @method static Builder|Users wherePhone($value)
 * @property-read \App\Models\MasterCompany|null $company
 * @mixin Eloquent
 */
class Users extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $guarded = 'id_user';
    protected $fillable = [
        'username',
        'password',
        'nama',
        'alamat',
        'email',
        'nrk',
        'phone',
        'image',
        'id_user_group',
        'id_company',
        'status',
        'created_by',
        'updated_by'
    ];

    public function userCreated(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'created_by', 'id_user');
    }

    public function userUpdated(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'updated_by', 'id_user');
    }

    public function userGroup(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class, 'id_user_group', 'id_user_group');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(MasterCompany::class, 'id_company', 'id_company');
    }

    public function privileges(): HasMany
    {
        return $this->hasMany(UserGroupPrivilege::class, 'id_user_group', 'id_user_group');

    }


}
