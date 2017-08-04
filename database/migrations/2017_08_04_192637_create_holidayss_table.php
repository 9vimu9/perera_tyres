<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidayssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('holiday_type_id');
            $table->timestamps();
            $table->foreign('holiday_type_id')->references('id')->on('holiday_types')->onDelete('cascade')->onUpdate('cascade');
          $table->unique(['date', 'holiday_type_id'],"composite 2");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holidays');
    }
}
