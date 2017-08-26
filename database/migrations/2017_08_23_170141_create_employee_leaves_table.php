<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('leave_type_id')->length(10)->unsigned();
            $table->integer('employee_id')->length(10)->unsigned();
            $table->date('from_date');
            $table->time('from_time');
            $table->date('to_date');
            $table->time('to_time');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('leaves');
    }
}
