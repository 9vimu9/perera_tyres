<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('is_compulsory_feature');//1=yes 0 no
            $table->integer('is_dynamic_value');//1=yes dynamic 0=no static
            $table->integer('value_type');//1=dynamic 0=precentage
            $table->float('static_value', 10, 2);
            $table->integer('feature_type');//1=allowence 0=deduction 2=demo
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
        Schema::dropIfExists('fixed_features');
    }
}
