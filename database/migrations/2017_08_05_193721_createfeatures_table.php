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
            $table->integer('is_static_value');//0= dynamic 1= static
            $table->integer('value_type');//0=fixed value from salary 1=precentage
            $table->float('static_value', 10, 2)->default(0);
            ;$table->integer('feature_type');//1=allowence 0=deduction 2=demo
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
