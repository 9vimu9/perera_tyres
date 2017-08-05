<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slips', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('salarys_id')->length(10)->unsigned();
              $table->integer('employee-basics_id')->length(10)->unsigned();
              $table->integer('employee_designations_id')->length(10)->unsigned();
              $table->timestamps();

              $table->foreign('salarys_id')->references('id')->on('salarys')->onDelete('cascade')->onUpdate('cascade');
              $table->foreign('employee-basics_id')->references('id')->on('employee-basics')->onDelete('cascade')->onUpdate('cascade');
              $table->foreign('employee_designations_id')->references('id')->on('employee_designations')->onDelete('cascade')->onUpdate('cascade');

              $table->unique(['employee-basics_id', 'salarys_id'],"composite slips");




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slips');
    }
}
