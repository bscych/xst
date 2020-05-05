<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeEndDateNullableToTableClassmodels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classmodels', function (Blueprint $table) {
            $table->date('end_date')->nullable()->comment('结束日期可以为空，为空表示没有结课的时间')->change();
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
