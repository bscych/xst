<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealbookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mealbookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('school_id');
            $table->unsignedInteger('student_id');
            $table->date('date')->comment('哪一天');
            $table->string('morning_snack',1)->default('0')->comment('0：不定餐，1：订餐');
            $table->string('afternoon_snack',1)->default('0')->comment('0：不定餐，1：订餐');
            $table->string('breakfast',1)->default('0')->comment('0：不定餐，1：订餐');
            $table->string('lunch',1)->default('0')->comment('0：不定餐，1：订餐');
            $table->string('dinner',1)->default('0')->comment('0：不定餐，1：订餐');            
            $table->timestamps();
            $table->index(['school_id','student_id','date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mealbookings');
    }
}
