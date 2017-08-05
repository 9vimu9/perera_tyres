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
        Schema::create('slip_custom-feature-values', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('slips_id')->length(10)->unsigned();
          $table->integer('custom-features_id')->length(10)->unsigned();
          $table->float('amount', 6, 2);
          $table->foreign('custom-features_id')->references('id')->on('custom-features')->onDelete('cascade')->onUpdate('cascade');
          $table->foreign('slips_id')->references('id')->on('slips')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('slip_custom-feature-values');
    }
}
