<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('first-name');
            $table->string('last-name');
            $table->mediumText('why-to-join');
            $table->mediumText('previous-experience');
            $table->date('date-of-birth');
            $table->string('password');
            $table->string('avatar')->default('default.jpg');
            $table->rememberToken();

            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->timestamps();
        });

        Schema::table('organizers', function (Blueprint $table) {
            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('gender_id')->references('id')->on('genders');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizers');
    }
}
