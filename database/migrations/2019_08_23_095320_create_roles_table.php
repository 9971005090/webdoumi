<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 15)->unique();
            $table->string('description', 100);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'user_name');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('user_name', 'name');
        });
    }
}
