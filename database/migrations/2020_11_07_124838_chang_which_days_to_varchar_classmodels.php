<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangWhichDaysToVarcharClassmodels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classmodels', function (Blueprint $table) {
            $table->string('which_days')->nullable()->comment('which day and at which time in pattern {day:1,time:{start_at:12:00,end_at:14:00}}')->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classmodels', function (Blueprint $table) {
            //
        });
    }
}
