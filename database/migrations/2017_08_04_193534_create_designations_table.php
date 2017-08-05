<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('cats_id')->length(10)->unsigned();
            $table->foreign('cats_id')->references('id')->on('cats')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['cats_id', 'name'],"composite designations");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('designations');
    }
}
