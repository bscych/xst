<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHomeworksSchoolNameIntoConstantSchoolId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('homeworks', function (Blueprint $table) {
           $table->dropColumn('school_name');          
           $table->unsignedInteger('constant_school_id')->comment('作业属于哪个学校');
           $table->index(['date', 'constant_school_id', 'grade', 'class']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('homeworks', function (Blueprint $table) {
            //
        });
    }
}
