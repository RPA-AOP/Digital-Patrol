<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Menus
 *
 * @method static Builder|Menus newModelQuery()
 * @method static Builder|Menus newQuery()
 * @method static Builder|Menus query()
 * @property-read \App\Models\Users $userCreated
 * @property-read \App\Models\Users $userUpdated
 * @property int $id_menu
 * @property string $title
 * @property string $icon
 * @property string $link
 * @property int $is_hidden
 * @property int $sort
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Menus whereCreatedAt($value)
 * @method static Builder|Menus whereCreatedBy($value)
 * @method static Builder|Menus whereIcon($value)
 * @method static Builder|Menus whereIdMenu($value)
 * @method static Builder|Menus whereIsHidden($value)
 * @method static Builder|Menus whereLink($value)
 * @method static Builder|Menus whereSort($value)
 * @method static Builder|Menus whereTitle($value)
 * @method static Builder|Menus whereUpdatedAt($value)
 * @method static Builder|Menus whereUpdatedBy($value)
 * @property string $type
 * @method static Builder|Menus whereType($value)
 * @property int|null $parent_id
 * @property string $name
 * @property string|null $slug
 * @property string $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Menus> $submenu
 * @property-read int|null $submenu_count
 * @method static Builder|Menus whereName($value)
 * @method static Builder|Menus whereParentId($value)
 * @method static Builder|Menus whereSlug($value)
 * @method static Builder|Menus whereUrl($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Menus> $submenu
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Menus> $submenu
 * @mixin Eloquent
 */
class Menus extends Model
{
  protected $table = 'menus';
  protected $primaryKey = 'id_menu';
  protected $fillable = [
    'title',
    'icon',
    'url',
    'slug',
    'parent_id',
    'is_hidden',
    'sort',
    'created_by',
    'updated_by'
  ];

  public function submenu()
  {
    return $this->hasMany(Menus::class, 'parent_id', 'id_menu');
  }

  public function userCreated()
  {
    return $this->belongsTo(Users::class, 'created_by', 'id_user');
  }

  public function userUpdated()
  {
    return $this->belongsTo(Users::class, 'updated_by', 'id_user');
  }
}
