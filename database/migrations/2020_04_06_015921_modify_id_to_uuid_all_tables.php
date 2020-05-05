<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyIdToUuidAllTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
//        Schema::table('schools', function (Blueprint $table) {
//            $table->uuid('id')->change();
//        });
//        Schema::table('courses', function (Blueprint $table) {
//            $table->uuid('id')->change();
//            $table->uuid('school_id')->after('id')->change();
//        });
//        Schema::table('classmodels', function (Blueprint $table) {
//            $table->uuid('id')->change();
//            $table->uuid('course_id')->change();
//        });
//        Schema::table('constants', function (Blueprint $table) {
//            $table->uuid('id')->change();
//        });
//        Schema::table('course_student', function (Blueprint $table) {
//            $table->uuid('school_id')->change();
//            $table->uuid('student_id')->change();
//            $table->uuid('course_id')->change();
//            $table->uuid('classmodel_id')->change();
//            $table->uuid('id')->change();
//        });
//        Schema::table('enrolls', function (Blueprint $table) {
//            $table->uuid('school_id')->change();
//            $table->uuid('id')->change();
//            $table->uuid('income_account')->change();
//            $table->uuid('course_id')->change();
//            $table->uuid('student_id')->change();            
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('schools', function (Blueprint $table) {
            //
        });
    }

}
