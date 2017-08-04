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
            $table->string('name');
            $table->string('address');
            $table->string('nic');
            $table->string('tel');
            $table->integer('etf_no')->unique();
            $table->time('start_time');
            $table->date('join_date');



            $table->integer('branch_id');
            $table->integer('cat_id');
            $table->integer('designation_id');
            $table->decimal('basic',7,2);
            $table->decimal('budget_allowance',7,2);
            //$table->decimal('unit_price',7,2);

            $table->foreign('branch_id')->references('id')->on('branchs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cat_id')->references('id')->on('cats')->onDelete('cascade')->onUpdate('cascade');


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
