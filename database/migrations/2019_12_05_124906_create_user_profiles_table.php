<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable(false)->comment('users 참조키');
            $table->string('phone', 45)->nullable(true)->comment('전화번호');
            $table->string('mobile_phone', 45)->nullable(true)->comment('휴대폰 번호');
            $table->string('gender', 1)->nullable(true)->default("M")->comment('성별, M(남)/F(여)');
            $table->dateTimeTz('birthday')->nullable(true)->comment('생일');
            $table->string('zipcode', 7)->nullable(true)->comment('우편번호');
            $table->string('address1', 255)->nullable(true)->comment('주소1');
            $table->string('address2', 255)->nullable(true)->comment('주소2');
            $table->text('memo')->nullable(true)->comment('기타설명');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.호
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
