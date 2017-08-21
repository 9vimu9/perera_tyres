<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_days', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('salary_id')->length(10)->unsigned();
          $table->date('date');
          $table->foreign('salary_id')->references('id')->on('salarys')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('working_days');
    }
}
