<?php

namespace App\Helpers;

use App\Models\Menus;
use App\Models\UserGroupPrivilege;
use Illuminate\Support\Facades\Auth;
use Menu;
use Spatie\Menu\Html;

class MenuBuilder
{
  public static function generateMenu(): \Spatie\Menu\Laravel\Menu
  {
    $userGroup = \Auth::user()->id_user_group;
    $userGroupPrivilages = UserGroupPrivilege::query()
      ->where('id_user_group', $userGroup)->get()
      ->pluck('id_menu');
    $objectMenu = Menus::whereIn('id_menu', $userGroupPrivilages)->orderBy('sort')->get();
    $builder = Menu::new()
      ->addClass('menu-inner py-1 ')
      ->setAttribute('id', 'main-menu-navigation')
      ->setAttribute('data-menu', 'menu-navigation')
      ->setActiveClass('active');

    foreach ($objectMenu as $menu) {
      switch ($menu['type']) {
        case 'menu':
          $builder->add(Html::raw('<a class="menu-link" href="' . url($menu['url']) . '"><i class="' . $menu['icon'] . '"></i><div>' . $menu['title'] . '</div></a>')
            ->setUrl(url($menu['url']))
            ->addParentClass('menu-item '))
            ->setActiveFromRequest();
          break;
        case 'label':
          $builder->add(Html::raw('<span data-i18n="' . $menu['title'] . '">' . $menu['title'] . '</span><i data-feather="more-horizontal"></i>')
            ->addParentClass('navigation-header'));
          break;
      }
    }
    return $builder;
  }

  public static function getMenu()
  {
    $userGroup = \Auth::user()->id_user_group;
    $userGroupPrivilages = UserGroupPrivilege::query()
      ->where('id_user_group', $userGroup)->get()
      ->pluck('id_menu');
    return Menus::whereIn('id_menu', $userGroupPrivilages)->whereParentId(null)->with('submenu')->orderBy('sort')->get();
  }
}
