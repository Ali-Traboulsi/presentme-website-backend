<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("event-title");
            $table->mediumText("event-description");
            $table->date('event-date');

            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->unsignedBigInteger('sub_cat_id')->nullable();
            $table->unsignedBigInteger('event_type_id')->nullable();

            $table->boolean('isActive')->default(false);

            $table->timestamps();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreign('organizer_id')->references('id')->on('organizers');
            $table->foreign('sub_cat_id')->references('id')->on('subCategories');
            $table->foreign('event_type_id')->references('id')->on('event_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');

    }
}
