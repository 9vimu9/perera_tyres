<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeDesignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_designations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employees_id')->length(10)->unsigned();
            $table->integer('designations_id')->length(10)->unsigned();
            $table->timestamps();
            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('designations_id')->references('id')->on('designations')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['employees_id', 'designations_id'],"composite employee_designations");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_designations');
    }
}
