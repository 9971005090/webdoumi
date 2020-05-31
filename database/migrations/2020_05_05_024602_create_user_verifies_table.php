<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVerifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verifies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable(false)->comment('users 참조키');
            $table->boolean('is_expire')->default(false)->nullable(false)->comment('유효여부');
            $table->string('token', 255)->nullable(false)->comment('토큰값');
            $table->timestamp('token_limited_at')->nullable(false)->comment('토큰 유효시간');
            $table->timestamp('token_used_at')->nullable(true)->comment('토큰 사용(인증)시간=users.email_verified_at');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_verifies');
    }
}
