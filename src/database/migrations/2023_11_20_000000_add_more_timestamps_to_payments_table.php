<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreTimestampsToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dateTime('process_start_at')->nullable();
            $table->dateTime('process_end_at')->nullable();
            $table->dateTime('failed_at')->nullable();
            $table->dateTime('closed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('payments', 'process_start_at');
        Schema::dropColumns('payments', 'process_end_at');
        Schema::dropColumns('payments', 'failed_at');
        Schema::dropColumns('payments', 'closed_at');
    }
}
