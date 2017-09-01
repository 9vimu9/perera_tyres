<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValueTypeForSlipFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('slip_features', function (Blueprint $table) {
        $table->integer('value_type');//0=fixed value from salary 1=precentage
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('slip_features', function (Blueprint $table) {
        $table->integer('value_type');//0=fixed value from salary 1=precentage
      });
    }
}
