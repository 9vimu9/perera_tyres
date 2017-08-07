<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatWorkingDaysTablee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_working_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cat_id')->length(10)->unsigned();
            $table->integer('is_sun_work');//1=working 0=holiday
            $table->integer('is_mon_work');//1=working 0=holiday
            $table->integer('is_tue_work');//1=working 0=holiday
            $table->integer('is_wed_work');//1=working 0=holiday
            $table->integer('is_thu_work');//1=working 0=holiday
            $table->integer('is_fri_work');//1=working 0=holiday
            $table->integer('is_sat_work');//1=working 0=holiday
            $table->timestamps();
            $table->foreign('cat_id')->references('id')->on('cats')->onDelete('cascade')->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_working_days');
    }
}
