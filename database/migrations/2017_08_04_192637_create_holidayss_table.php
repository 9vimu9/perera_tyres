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
            $table->integer('holiday_type_id')->length(10)->unsigned();
            $table->foreign('holiday_type_id')->references('id')->on('holiday_types')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->unique(['date', 'holiday_type_id'],"composite holidays");
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
