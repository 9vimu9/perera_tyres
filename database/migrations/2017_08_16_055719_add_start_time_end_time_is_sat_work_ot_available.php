<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartTimeEndTimeIsSatWorkOtAvailable extends Migration
{
    // /**
    //  * Run the migrations.
    //  *
    //  * @return void
    //  */
    public function up()
    {
      Schema::table('slips', function (Blueprint $table) {
        $table->time('start_time');
        $table->time('end_time');
        $table->integer('ot_available')->length(1)->unsigned();//1=available 0=not available
        $table->integer('is_sat_work')->length(1)->unsigned();//1=woking 0=holiday

      });
    }
    //
    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //   Schema::table('slips', function (Blueprint $table) {
    //     $table->time('start_time');
    //     $table->time('end_time');
    //     $table->integer('ot_available')->length(1)->unsigned();//1=available 0=not available
    //     $table->integer('is_sat_work')->length(1)->unsigned();//1=woking 0=holiday
    //
    //   });
    // }
}
