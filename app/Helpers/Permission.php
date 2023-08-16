<?php

namespace App\Helpers;


use App\Models\Menus;
use App\Models\UserGroupPrivilege;
use App\Models\UserPrivileges;
use App\Models\Users;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use stdClass;

class Permission
{
    public static function get()
    {
        $default_priv = new stdClass();
        $default_priv->has_view = 0;
        $default_priv->has_create = 0;
        $default_priv->has_edit = 0;
        $default_priv->has_download = 0;
        $default_priv->has_delete = 0;


        $current_url = '/' . Request::segment(1);

        $menu = Menus::where('url', $current_url)->first();
        if (!$menu) {
            activity('page_access_denied')
                ->event('access_denied')
                ->withProperties(Request::header())
                ->log(Request::url());
            abort(403);
        }
        $user = Users::query()->select('id_user_group')
            ->where('id_user', Session::get('id_user'))->first();

        $priv = UserGroupPrivilege::where('id_user_group', $user->id_user_group)
            ->where('id_menu', $menu->id_menu)
            ->select('has_view', 'has_create', 'has_edit', 'has_download', 'has_delete')
            ->first();
        if ($priv) {
            return $priv;
        } else {
            activity('page_access_denied')
                ->event('access_denied')
                ->withProperties(Request::header())
                ->log(Request::url());
            abort(403);

        }
    }
}
