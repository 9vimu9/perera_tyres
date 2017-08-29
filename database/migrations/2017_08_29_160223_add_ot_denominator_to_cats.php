<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtDenominatorToCats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('cats', function (Blueprint $table) {
          $table->integer('ot_denominator');
          $table->double('ot_multiplier');

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('cats', function (Blueprint $table) {
          $table->integer('ot_denominator');
          $table->double('ot_multiplier');

      });
    }
}
