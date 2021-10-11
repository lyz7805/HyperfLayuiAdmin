<?php

declare(strict_types=1);

use Hyperf\DbConnection\Db;
use Hyperf\Database\Seeders\Seeder;

class AdminRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [[
            'id' => 1,
            'name' => '管理员',
            'state' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]];
        Db::connection($this->getConnection())->table('admin_role')
            ->insert($roles);
    }
}
