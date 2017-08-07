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
              $table->integer('salary_id')->length(10)->unsigned();
              $table->integer('basic_salary_id')->length(10)->unsigned();
              $table->integer('employee__designation_id')->length(10)->unsigned();
              $table->timestamps();

              $table->foreign('salary_id')->references('id')->on('salarys')->onDelete('cascade')->onUpdate('cascade');
              $table->foreign('basic_salary_id')->references('id')->on('basic_salarys')->onDelete('cascade')->onUpdate('cascade');
              $table->foreign('employee__designation_id')->references('id')->on('employee__designations')->onDelete('cascade')->onUpdate('cascade');

              $table->unique(['basic_salary_id', 'salary_id'],"composite slips");




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
