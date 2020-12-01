<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_teams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('team_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        //Schema::enableForeignKeyConstraints();

        Schema::table('member_teams', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_teams');
    }
}
