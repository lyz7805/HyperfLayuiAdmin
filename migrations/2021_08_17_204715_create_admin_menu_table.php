<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminMenuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_menu', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->comment('菜单表');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->comment('父ID');
            $table->string('title', 50)->comment('菜单标题'); // ->unique();
            $table->string('icon', 50)->comment('菜单图标');
            $table->string('href', 50)->nullable()->comment('菜单链接');
            $table->string('target', 10)->default('_self')->comment('打开方式');
            $table->unsignedTinyInteger('is_menu')->default(1)->comment('是否菜单');
            $table->integer('sort', false, true)->default(100)->comment('排序');
            $table->string('permission')->comment('权限')->nullable();
            $table->unsignedTinyInteger('state', false)->default(1)->comment('状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_menu');
    }
}
