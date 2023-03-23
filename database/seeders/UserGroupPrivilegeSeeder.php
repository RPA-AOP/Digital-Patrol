<?php

namespace Database\Seeders;

use App\Models\Menus;
use App\Models\UserGroup;
use App\Models\UserGroupPrivilege;
use Illuminate\Database\Seeder;

class UserGroupPrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = UserGroup::select('id_user_group as id')->get();
        $menus = Menus::where('is_hidden', 0)->orderBy('sort', 'ASC')
            ->select('id_menu as id')->get();

        foreach ($groups as $group) {
            foreach ($menus as $menu) {
                $data = new UserGroupPrivilege();
                $data->id_user_group = $group->id;
                $data->id_menu = $menu->id;
                $data->has_create = 1;
                $data->has_view = 1;
                $data->has_edit = 1;
                $data->has_download = 1;
                $data->has_delete = 1;

                if (in_array($group->id, [ 4, 5, 6, 7])) {
                    if (in_array($menu->id, [1, 2, 3])) {
                        $data->has_create = 0;
                        $data->save();
                    }
                }elseif ($group->id==3){
                    if (in_array($menu->id, [1, 2, 3])) {
                        $data->has_create = 1;
                        $data->save();
                    }
                }elseif ($group->id==1){
                    $data->save();
                }
            }
        }
    }
}
