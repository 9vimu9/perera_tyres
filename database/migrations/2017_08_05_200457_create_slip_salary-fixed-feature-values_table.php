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
        Schema::create('slip__fixed_feature_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slip_id')->length(10)->unsigned();
            $table->integer('fixed_feature_value_id')->length(10)->unsigned();
            $table->timestamps();
            $table->foreign('slip_id')->references('id')->on('slips')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fixed_feature_value_id')->references('id')->on('fixed_feature_values')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['slip_id', 'fixed_feature_value_id'],"composite slip__fixed_feature_values");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slip__fixed_feature_values');
    }
}
