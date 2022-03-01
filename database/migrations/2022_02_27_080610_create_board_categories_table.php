<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('board_info_id')->unsigned()->nullable(false)->comment('users 참조키')->index();
            $table->string('title', 255)->comment('이름');
            $table->timestamps();
            $table->foreign('board_info_id')->references('id')->on('board_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_categories');
    }
}
