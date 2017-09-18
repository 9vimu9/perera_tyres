<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id')->length(10)->unsigned();
            $table->integer('cat_id')->length(10)->unsigned();
            $table->integer('designation_id')->length(10)->unsigned();
            $table->integer('fingerprint_no');
            $table->string('name');
            $table->string('address');
            $table->string('nic');
            $table->string('tel');
            $table->integer('epf_no');
            $table->time('start_time');
            $table->time('end_time');
            $table->date('join_date');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('branch_id')->references('id')->on('branchs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cat_id')->references('id')->on('cats')->onDelete('cascade')->onUpdate('cascade');
            $table->float('basic_salary', 10, 2);
            $table->integer('ot_available')->length(1)->unsigned();
            $table->integer('is_sat_work')->length(1)->unsigned();//1=working 0=holiday
            $table->integer('is_epf');//0=fixed value from salary 1=precentage
            $table->float('per_day_salary',10,2);//0=fixed value from salary 1=precentage
            $table->float('actual_salary',10,2);//0=fixed value from salary 1=precentage


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
        Schema::dropIfExists('employees');
    }
}
