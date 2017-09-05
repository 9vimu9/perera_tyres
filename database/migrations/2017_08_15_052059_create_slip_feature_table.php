<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlipFeatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slip_features', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slip_id')->length(10)->unsigned();
            $table->integer('feature_id')->length(10)->unsigned();
            $table->float('static_value', 10, 2)->default(0);//if feature static then its static value
            $table->float('value', 10, 2)->default(0);
            $table->integer('value_type')->default(0);//0=fixed value from salary 1=precentage
            $table->timestamps();
            $table->foreign('slip_id')->references('id')->on('slips')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['slip_id', 'feature_id'],"composite slip_features");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slip_features');
    }
}
