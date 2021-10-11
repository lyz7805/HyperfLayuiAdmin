<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminOperationLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_operation_log', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->comment('操作记录表');

            $table->bigIncrements('id');
            $table->bigInteger('user_id', false, true)->comment('用户ID');
            $table->string('ip')->comment('IP');
            $table->text('path')->comment('路径');
            $table->string('method', 64)->comment('方法');
            $table->json('params')->nullable()->comment('参数');
            $table->text('result')->nullable()->comment('结果');
            $table->float('runtime', false, true)->comment('执行时间（秒）');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_operation_log');
    }
}
