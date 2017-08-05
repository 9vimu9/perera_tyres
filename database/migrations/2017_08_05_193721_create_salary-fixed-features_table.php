<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryFixedFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed-features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('fixed_method', ['amount', 'precentage']);
            $table->integer('is_compulsory');//1=yes 0 no
            $table->enum('feature_type', ['deduction', 'allowance','demo']);
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
        Schema::dropIfExists('fixed-features');
    }
}
