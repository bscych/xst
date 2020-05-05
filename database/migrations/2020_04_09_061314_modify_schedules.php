<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->after('classmodel_id');
            $table->char('attend', 1)->default(0)->comment('是否出席，1：出席，0：缺席')->after('date');
            $table->char('lunch', 1)->default(0)->comment('是否订午餐，1：订，0：不订')->after('attend');
            $table->char('dinner', 1)->default(0)->comment('是否订晚餐，1：订，0：不订')->after('lunch');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            //
        });
    }
}
