<?php

declare(strict_types=1);

use App\Utils;
use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultPwd = 'admin';
        $salt = Utils::createRandStr(64);
        $password = Utils::encryptPassword($defaultPwd, $salt);

        $insert = [
            'id' => 1,
            'username' => 'admin',
            'password' => $password,
            'salt' => $salt,
            'name' => 'Admin',
            'created_at' => date('Y-m-d H:i:s')
        ];
        Db::connection($this->getConnection())->table('admin_user')
            ->insert($insert);
    }
}
