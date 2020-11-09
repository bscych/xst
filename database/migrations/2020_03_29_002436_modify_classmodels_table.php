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
          
            $table->renameColumn('which_day_1','which_days');          
            $table->dropColumn('which_day_2');
            $table->dropColumn('block1_end_time');
            $table->dropColumn('block1_start_time');
            $table->dropColumn('block2_end_time');
            $table->dropColumn('block2_start_time');           
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
