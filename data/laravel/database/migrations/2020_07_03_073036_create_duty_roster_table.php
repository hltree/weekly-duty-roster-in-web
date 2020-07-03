<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDutyRosterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duty_roster', function (Blueprint $table) {
            $table->id();
            $table->string('sun');
            $table->string('mon');
            $table->string('tue');
            $table->string('wed');
            $table->string('thu');
            $table->string('fri');
            $table->string('sat');
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
        Schema::dropIfExists('duty_roster');
    }
}
