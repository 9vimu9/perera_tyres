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
              $table->integer('employee_id')->length(10)->unsigned();
              $table->float('basic_salary', 10, 2);
              $table->float('ot_hours', 10, 2);
              $table->float('ot_value', 10, 2);
              $table->float('nopay_days', 10, 2);
              $table->float('nopay_value', 10, 2);
              $table->timestamps();
              $table->foreign('salary_id')->references('id')->on('salarys')->onDelete('cascade')->onUpdate('cascade');
              $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');

              $table->unique(['employee_id', 'salary_id'],"composite slips");




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
