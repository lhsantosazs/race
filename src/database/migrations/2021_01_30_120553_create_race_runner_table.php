<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaceRunnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_runner', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('runner_id')->unsigned();
            $table->foreign('runner_id')
                  ->references('id')
                  ->on('runner')
                  ->onDelete('cascade');
            $table->integer('race_id')->unsigned();
            $table->foreign('race_id')
                  ->references('id')
                  ->on('race')
                  ->onDelete('cascade');
            $table->dateTime('race_start')->nullable();
            $table->dateTime('race_end')->nullable();
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
        Schema::dropIfExists('race_runner');
    }
}
