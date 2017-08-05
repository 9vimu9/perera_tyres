<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeBasicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee-basics', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('employees_id')->length(10)->unsigned();
          $table->float('amount', 6, 2);
          $table->timestamps();
          $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee-basics');
    }
}
