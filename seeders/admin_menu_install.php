<?php

declare(strict_types=1);

use Hyperf\DbConnection\Db;
use Hyperf\Database\Seeders\Seeder;

class AdminMenuInstall extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            ['id' => 100, 'title' => '系统管理', 'icon' => 'fa fa-address-book', 'href' => null, 'target' => '_self', 'sort' => 0, 'parent_id' => 0],

            ['id' => 101, 'title' => '首页', 'icon' => 'fa fa-tachometer', 'href' => 'page/welcome.html', 'target' => '_self', 'sort' => 100, 'parent_id' => 100],
            ['id' => 102, 'title' => '菜单管理', 'icon' => 'fa fa-window-maximize', 'href' => 'page/menu/list.html', 'target' => '_self', 'sort' => 100, 'parent_id' => 100],
            ['id' => 103, 'title' => '用户管理', 'icon' => 'fa fa-user', 'href' => 'page/user/list.html', 'target' => '_self', 'sort' => 100, 'parent_id' => 100],
            ['id' => 104, 'title' => '角色管理', 'icon' => 'fa fa-group', 'href' => 'page/role/list.html', 'target' => '_self', 'sort' => 100, 'parent_id' => 100],
            ['id' => 105, 'title' => '操作记录', 'icon' => 'fa fa-list-alt', 'href' => 'page/operation_log/list.html', 'target' => '_self', 'sort' => 100, 'parent_id' => 100],
        ];

        $time = date('Y-m-d H:i:s');
        foreach ($menus as &$menu) {
            $menu['permission'] = null;
            $menu['created_at'] = $time;
            $menu['updated_at'] = null;
        }
        Db::connection($this->getConnection())->table('admin_menu')
            ->insert($menus);
    }
}
