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
              $table->float('ot_rate', 10, 2);
              $table->float('nopay_rate', 10, 2);
              $table->time('start_time');
              $table->time('end_time');
              $table->integer('ot_available')->length(1)->unsigned();//1=available 0=not available
              $table->integer('is_sat_work')->length(1)->unsigned();//1=woking 0=holiday
              $table->date('date_paid');
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
