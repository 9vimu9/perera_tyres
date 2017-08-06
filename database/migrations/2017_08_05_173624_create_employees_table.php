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
            $table->integer('branchs_id')->length(10)->unsigned();
            $table->integer('cats_id')->length(10)->unsigned();
            $table->integer('fingerprint_no');
            $table->string('name');
            $table->string('address');
            $table->string('nic');
            $table->string('tel');
            $table->integer('epf_no');
            $table->time('start_time');
            $table->date('join_date');
            $table->foreign('branchs_id')->references('id')->on('branchs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cats_id')->references('id')->on('cats')->onDelete('cascade')->onUpdate('cascade');
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
