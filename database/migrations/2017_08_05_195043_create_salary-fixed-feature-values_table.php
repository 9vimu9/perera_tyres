<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryFixedFeatureValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed-feature-values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fixed-features_id')->length(10)->unsigned();
            $table->float('amount', 6, 2);
            $table->foreign('fixed-features_id')->references('id')->on('fixed-features')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('fixed-feature-values');
    }
}
