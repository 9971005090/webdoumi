<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManyToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_name', 15)->nullable(true)->after('id')->comment('권한이름');
            $table->string('real_name', 100)->after('user_name')->comment('실제이름');
            $table->boolean('confirmed')->default(false)->after('remember_token')->comment('승인여부');
            $table->boolean('suspended')->default(false)->after('confirmed')->comment('불량회원-로그인안됨');
            $table->smallInteger('failed_count')->default(0)->after('suspended')->comment('로그인실패횟수-성공시초기화');
            $table->dateTimeTz('locked')->nullable(true)->after('failed_count')->comment('로그인실패횟수 초과하여 로그인 제한-일정시간 후 가능');
            $table->dateTimeTz('password_changed')->nullable(true)->after('locked')->comment('비밀번호변경날짜');
            $table->dateTimeTz('password_notice_dismissed')->nullable(true)->after('password_changed')->comment('비밀번호변경 나중에 설정 시간');
            $table->dateTimeTz('last_login')->nullable(true)->after('password_notice_dismissed')->comment('마지막 로그인 시간');
            $table->string('last_login_ip', 15)->nullable(true)->after('last_login')->comment('마지막 로그인 ip');
            $table->dateTimeTz('joined')->nullable(true)->after('last_login_ip')->comment('회원가입날짜');
            $table->boolean('agree_to_advertise')->default(false)->after('joined')->comment('광고성내용 수신 동의여부');
            $table->dateTimeTz('setup_to_advertise')->nullable(true)->after('agree_to_advertise')->comment('광고성내용 설정 시간');
            $table->string('user_name', 50)->change();
            $table->foreign('role_name', 'users_role_name_foreign')->references('name')->on('roles')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_role_name_foreign');
            $table->dropColumn('role_name');
            $table->dropColumn('real_name');
            $table->dropColumn('confirmed');
            $table->dropColumn('suspended');
            $table->dropColumn('failed_count');
            $table->dropColumn('locked');
            $table->dropColumn('password_changed');
            $table->dropColumn('password_notice_dismissed');
            $table->dropColumn('last_login');
            $table->dropColumn('last_login_ip');
            $table->dropColumn('joined');
            $table->dropColumn('agree_to_advertise');
            $table->dropColumn('setup_to_advertise');
        });
    }
}
