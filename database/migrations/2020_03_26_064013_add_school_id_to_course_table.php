<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchoolIdToCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->comment('学校ID');
            $table->unsignedBigInteger('created_by')->comment('创建者ID');
            $table->char('is_speciality_course',1)->comment('是否是特长课，1：是，0：不是')->default(0);
            $table->dropColumn('snack_fee');
            $table->dropColumn('course_category_id');
            $table->dropColumn('teacher_id');
            $table->dropColumn('classroom_id');
            $table->dropColumn('which_day_1');
            $table->dropColumn('block1_start_time');
            $table->dropColumn('block1_end_time');
            $table->dropColumn('which_day_2');
            $table->dropColumn('block2_start_time');
            $table->dropColumn('block2_end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            //
        });
    }
}
