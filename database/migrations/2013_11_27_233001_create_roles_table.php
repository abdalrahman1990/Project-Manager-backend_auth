<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->primary(['user_id', 'role']);
            $table->integer('user_id')->unsigned();
            $table->string('role');
            //$table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });

       /* Schema::enableForeignKeyConstraints();

        Schema::table('roles', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('role_id')->references('id')->on('roles');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
