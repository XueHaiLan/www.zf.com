<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            //角色id
            $table->unsignedInteger('role_id')->default(1)->comment('角色id');
            $table->string('username',50)->comment('账号');
            $table->string('truename',50)->default('未知')->comment('真实姓名');
            $table->string('password',255)->comment('密码');
            //nullable----可以使null
            $table->string('email',50)->nullable()->comment('邮箱');
            $table->string('phone',15)->default('')->comment('手机号码');
            $table->enum('sex',['先生','女士'])->default('先生')->comment('性别');
            $table->char('last_ip',15)->default('')->comment('ip地址');
            $table->timestamps();
            $table->rememberToken();
            //软删除 生成一段字 deleted_at字段
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
