<?php

namespace Database\Seeders;

use App\Models\Menus;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = [
      [
        'name' => 'Dashboard',
        'icon' => 'menu-icon tf-icons ti ti-smart-home',
        'url' => '/',
        'type' => 'menu',
        'slug' => 'dashboard',
        'is_hidden' => 0,
        'created_by' => 1,
        'updated_by' => 0,

      ],
      [
        'name' => 'Report',
        'url' => "#",
        'icon' => null,
        'type' => 'label',
        'slug' => 'report',
        'is_hidden' => 0,
        'created_by' => 1,
        'updated_by' => 0,
      ],
      [
        'name' => 'Patrol Report',
        'icon' => 'menu-icon tf-icons ti ti-report',
        'url' => '/report-patrol',
        'slug' => 'report.patrol',
        'type' => 'menu',
        'is_hidden' => 0,
        'created_by' => 1,
        'updated_by' => 0
      ],
      [
        'name' => 'Patrol',
        'url' => "#",
        'icon' => null,
        'type' => 'label',
        'slug' => 'patrol',
        'is_hidden' => 0,
        'created_by' => 1,
        'updated_by' => 0,
      ],
      [
        'name' => 'Area Configuration',
        'icon' => 'menu-icon tf-icons ti ti-settings',
        'url' => '/patrolconfig',
        'slug' => 'patrolconfig',
        'type' => 'menu',
        'is_hidden' => 0,
        'created_by' => 1,
        'updated_by' => 0
      ],
      [
        'name' => 'Shift & Scheduling',
        'icon' => 'menu-icon tf-icons ti ti-calendar-stats',
        'url' => '/scheduleconfig',
        'slug' => 'scheduleconfig',
        'type' => 'menu',
        'is_hidden' => 0,
        'created_by' => 1,
        'updated_by' => 0
      ],
      [
        'name' => 'Master',
        'url' => "#",
        'icon' => null,
        'type' => 'label',
        'is_hidden' => 0,
        'slug' => 'master',
        'created_by' => 1,
        'updated_by' => 0,
      ],
      [
        'name' => 'Perusahaan',
        'icon' => 'menu-icon tf-icons ti ti-apps',
        'url' => '/master-company',
        'type' => 'menu',
        'slug' => 'master.company',
        'is_hidden' => 0,
        'created_by' => 1,
        'updated_by' => 0
      ],
      [
        'name' => 'User & Authentication',
        'url' => "#",
        'icon' => null,
        'type' => 'label',
        'slug' => 'user-auth',
        'is_hidden' => 0,
        'created_by' => 1,
        'updated_by' => 0,
      ],
      [
        'name' => 'Management User',
        'icon' => 'menu-icon tf-icons ti ti-users',
        'url' => '/management-user',
        'type' => 'menu',
        'slug' => 'management-user',
        'is_hidden' => 0,
        'created_by' => 1,
        'updated_by' => 0
      ]
    ];

    foreach ($data as $key => $dt) {
      $MN = new Menus();
      $MN->name = $dt['name'];
      $MN->icon = $dt['icon'];
      $MN->url = $dt['url'];
      $MN->is_hidden = $dt['is_hidden'];
      $MN->type = $dt['type'];
      $MN->sort = $key;
      $MN->slug = $dt['slug'];
      $MN->created_by = $dt['created_by'];
      $MN->updated_by = $dt['updated_by'];
      $MN->save();
      if (array_key_exists('submenu', $dt)){
        foreach ($dt['submenu'] as $k=>$submenu) {
          $MNSub = new Menus();
          $MNSub->name = $submenu['name'];
          $MNSub->icon = $submenu['icon'];
          $MNSub->url = $submenu['url'];
          $MNSub->is_hidden = $submenu['is_hidden'];
          $MNSub->type = $submenu['type'];
          $MNSub->slug = $submenu['slug'];
          $MNSub->parent_id = $MN->id_menu;
          $MNSub->sort = $k;
          $MNSub->created_by = $submenu['created_by'];
          $MNSub->updated_by = $submenu['updated_by'];

          $MNSub->save();
        }
      }
    }
  }
}
