<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlipSalaryFixedFeatureValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slip_fixed-feature-values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slips_id')->length(10)->unsigned();
            $table->integer('fixed-feature-values_id')->length(10)->unsigned();
            $table->timestamps();
            $table->foreign('slips_id')->references('id')->on('slips')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fixed-feature-values_id')->references('id')->on('fixed-feature-values')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['slips_id', 'fixed-feature-values_id'],"composite slip_fixed-feature-values");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slip_fixed-feature-values');
    }
}
