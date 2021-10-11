<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->comment('管理员表');

            $table->bigIncrements('id');
            $table->string('username', 190)->comment('用户名')->unique();
            $table->string('password', 60)->comment('密码');
            $table->string('salt', 64)->comment('盐值');
            $table->string('name')->comment('昵称');
            $table->string('avatar')->nullable()->comment('头像');
            $table->tinyInteger('state', false, true)->default(1)->comment('状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_user');
    }
}
