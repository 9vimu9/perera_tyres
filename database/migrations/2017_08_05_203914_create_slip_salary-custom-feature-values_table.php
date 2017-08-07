<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlipSalaryCustomFeatureValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slip__custom_feature_values', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('slip_id')->length(10)->unsigned();
          $table->integer('custom_feature_id')->length(10)->unsigned();
          $table->float('amount', 6, 2);
          $table->foreign('custom_feature_id')->references('id')->on('custom_features')->onDelete('cascade')->onUpdate('cascade');
          $table->foreign('slip_id')->references('id')->on('slips')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('slip__custom_feature_values');
    }
}
