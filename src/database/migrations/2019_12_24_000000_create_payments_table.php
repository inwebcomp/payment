<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use InWeb\Media\Image;

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
            $table->increments('id');
            $table->string('payer_type')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('payable_type')->nullable();
            $table->unsignedInteger('payable_id')->nullable();
            $table->tinyInteger('status');
            $table->double('amount');
            $table->text('detail')->nullable();
            $table->timestamps();
            $table->dateTime('canceled_at')->nullable();
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
