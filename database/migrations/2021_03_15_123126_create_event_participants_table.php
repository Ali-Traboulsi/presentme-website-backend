<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_participants', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('participant_id')->nullable();

            $table->unsignedBigInteger('event_id')->nullable();

            $table->timestamps();
        });

        Schema::table('event_participants', function (Blueprint $table) {
            $table->foreign('participant_id')->references('id')->on('participants');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_participants');
    }
}
