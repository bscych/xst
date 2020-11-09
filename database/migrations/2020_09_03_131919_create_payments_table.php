<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(true);
            $table->unsignedInteger('student_id');
            $table->double('total', 8, 2)->comment('金额合计');
            $table->unsignedInteger('operator')->comment('收款人');
            $table->string('comment')->comment('缴费备注')->nullable(true);
            $table->unsignedInteger('receipt_id')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
