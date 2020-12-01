<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 255);
            $table->string('done')->default('false');
            $table->date('begin_date');
            $table->date('deadline');
            $table->bigInteger('milestone_id')->unsigned();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        Schema::table('tasks', function($table) {
            $table->foreign('milestone_id')->references('id')->on('milestones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
