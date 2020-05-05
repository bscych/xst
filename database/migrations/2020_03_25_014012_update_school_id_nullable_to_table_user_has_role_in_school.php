<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSchoolIdNullableToTableUserHasRoleInSchool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_has_role_in_school', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable(true)->comment('学校ID,可以为null，表明是bscych创建的用户')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_has_role_in_school', function (Blueprint $table) {
            //
        });
    }
}
