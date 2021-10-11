<?php

declare(strict_types=1);

use Hyperf\DbConnection\Db;
use Hyperf\Database\Seeders\Seeder;

class AdminRoleMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = [];
        $data = [
            1 => Db::connection($this->getConnection())->table('admin_menu')->where('id', '>=', 100)->pluck('id')->toArray(),
        ];
        foreach ($data as $roleId => $menuIds) {
            array_walk($menuIds, function ($menuId) use (&$roleId, &$insert) {
                $insert[] = [
                    'role_id' => $roleId,
                    'menu_id' => $menuId
                ];
            });
        }
        if (count($insert)) {
            Db::connection($this->getConnection())->table('admin_role_menu')
                ->insert($insert);
        }
    }
}
