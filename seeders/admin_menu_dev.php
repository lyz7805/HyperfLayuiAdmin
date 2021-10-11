<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class AdminMenuDev extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('app_env', 'prod') == 'dev') {
            $menus = [
                [
                    'id' => 1,
                    'parent_id' => 0,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '常规管理',
                    'icon' => 'fa fa-address-book',
                    'href' => null,
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 2,
                    'parent_id' => 1,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '主页模板',
                    'icon' => 'fa fa-home',
                    'href' => null,
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 3,
                    'parent_id' => 2,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '主页一',
                    'icon' => 'fa fa-tachometer',
                    'href' => 'page/welcome-1.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 4,
                    'parent_id' => 2,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '主页二',
                    'icon' => 'fa fa-tachometer',
                    'href' => 'page/welcome-2.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 5,
                    'parent_id' => 2,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '主页三',
                    'icon' => 'fa fa-tachometer',
                    'href' => 'page/welcome-3.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 6,
                    'parent_id' => 1,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '菜单管理',
                    'icon' => 'fa fa-window-maximize',
                    'href' => 'page/menu.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 7,
                    'parent_id' => 1,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '系统设置',
                    'icon' => 'fa fa-gears',
                    'href' => 'page/setting.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 8,
                    'parent_id' => 1,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '表格示例',
                    'icon' => 'fa fa-file-text',
                    'href' => 'page/table.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 9,
                    'parent_id' => 1,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '表单示例',
                    'icon' => 'fa fa-calendar',
                    'href' => null,
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 10,
                    'parent_id' => 9,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '普通表单',
                    'icon' => 'fa fa-list-alt',
                    'href' => 'page/form.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 11,
                    'parent_id' => 9,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '分步表单',
                    'icon' => 'fa fa-navicon',
                    'href' => 'page/form-step.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 12,
                    'parent_id' => 1,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '登录模板',
                    'icon' => 'fa fa-flag-o',
                    'href' => null,
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 13,
                    'parent_id' => 12,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '登录-1',
                    'icon' => 'fa fa-stumbleupon-circle',
                    'href' => 'page/login-1.html',
                    'target' => '_blank',
                    'state' => 1,
                ], [
                    'id' => 14,
                    'parent_id' => 12,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '登录-2',
                    'icon' => 'fa fa-viacoin',
                    'href' => 'page/login-2.html',
                    'target' => '_blank',
                    'state' => 1,
                ], [
                    'id' => 15,
                    'parent_id' => 12,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '登录-3',
                    'icon' => 'fa fa-tags',
                    'href' => 'page/login-3.html',
                    'target' => '_blank',
                    'state' => 1,
                ], [
                    'id' => 16,
                    'parent_id' => 1,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '异常页面',
                    'icon' => 'fa fa-home',
                    'href' => null,
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 17,
                    'parent_id' => 16,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '404页面',
                    'icon' => 'fa fa-hourglass-end',
                    'href' => 'page/404.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 18,
                    'parent_id' => 1,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '其它界面',
                    'icon' => 'fa fa-snowflake-o',
                    'href' => null,
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 19,
                    'parent_id' => 18,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '按钮示例',
                    'icon' => 'fa fa-snowflake-o',
                    'href' => 'page/button.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 20,
                    'parent_id' => 18,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '弹出层',
                    'icon' => 'fa fa-shield',
                    'href' => 'page/layer.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 21,
                    'parent_id' => 0,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '组件管理',
                    'icon' => 'fa fa-lemon-o',
                    'href' => null,
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 22,
                    'parent_id' => 21,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '图标列表',
                    'icon' => 'fa fa-dot-circle-o',
                    'href' => 'page/icon.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 23,
                    'parent_id' => 21,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '图标选择',
                    'icon' => 'fa fa-adn',
                    'href' => 'page/icon-picker.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 24,
                    'parent_id' => 21,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '颜色选择',
                    'icon' => 'fa fa-dashboard',
                    'href' => 'page/color-select.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 25,
                    'parent_id' => 21,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '下拉选择',
                    'icon' => 'fa fa-angle-double-down',
                    'href' => 'page/table-select.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 26,
                    'parent_id' => 21,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '文件上传',
                    'icon' => 'fa fa-arrow-up',
                    'href' => 'page/upload.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 27,
                    'parent_id' => 21,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '富文本编辑器',
                    'icon' => 'fa fa-edit',
                    'href' => 'page/editor.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 28,
                    'parent_id' => 21,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '省市县区选择器',
                    'icon' => 'fa fa-rocket',
                    'href' => 'page/area.html',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 29,
                    'parent_id' => 0,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '其它管理',
                    'icon' => 'fa fa-slideshare',
                    'href' => null,
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 30,
                    'parent_id' => 29,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '多级菜单',
                    'icon' => 'fa fa-meetup',
                    'href' => null,
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 31,
                    'parent_id' => 30,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '按钮1',
                    'icon' => 'fa fa-calendar',
                    'href' => 'page/button.html?v=1',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 32,
                    'parent_id' => 31,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '按钮2',
                    'icon' => 'fa fa-snowflake-o',
                    'href' => 'page/button.html?v=2',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 33,
                    'parent_id' => 32,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '按钮3',
                    'icon' => 'fa fa-snowflake-o',
                    'href' => 'page/button.html?v=3',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 34,
                    'parent_id' => 32,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '表单4',
                    'icon' => 'fa fa-calendar',
                    'href' => 'page/form.html?v=1',
                    'target' => '_self',
                    'state' => 1,
                ], [
                    'id' => 35,
                    'parent_id' => 29,
                    'is_menu' => 1,
                    'sort' => 100,
                    'title' => '失效菜单',
                    'icon' => 'fa fa-superpowers',
                    'href' => 'page/error.html',
                    'target' => '_self',
                    'state' => 1,
                ],
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
}
