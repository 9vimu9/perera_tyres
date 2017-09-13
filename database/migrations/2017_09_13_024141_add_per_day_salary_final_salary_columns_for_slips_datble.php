<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerDaySalaryFinalSalaryColumnsForSlipsDatble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('slips', function (Blueprint $table) {
        $table->float('per_day_salary',10,2);//0=fixed value from salary 1=precentage
        $table->float('actual_salary',10,2);//0=fixed value from salary 1=precentage

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('slips', function (Blueprint $table) {
        $table->float('per_day_salary',10,2);//0=fixed value from salary 1=precentage
        $table->float('actual_salary',10,2);//0=fixed value from salary 1=precentage

      });
    }
}
