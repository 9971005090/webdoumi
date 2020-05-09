<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 255)->nullable(false)->comment('옵션 key');
            $table->longText('value')->comment('옵션 value');
            $table->string('label', 255)->nullable(true)->comment('옵션 이름');
            $table->boolean('html_check')->default(false)->comment('html 사용여부');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_options');
    }
}
