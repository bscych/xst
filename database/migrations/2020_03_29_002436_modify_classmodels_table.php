<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyClassmodelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classmodels', function (Blueprint $table) {
            $table->dropColumn('which_day_1');
            $table->dropColumn('which_day_2');
            $table->dropColumn('block1_end_time');
            $table->dropColumn('block1_start_time');
            $table->dropColumn('block2_end_time');
            $table->dropColumn('block2_start_time');
            $table->char('which_days')->comment('每周几上课')->default('[0,1,2,3,4,5,6]');
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
