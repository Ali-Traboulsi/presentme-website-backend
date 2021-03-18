<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subCategories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("subCategory_name");
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->timestamps();
        });

        Schema::table('subCategories', function (Blueprint $table) {
            $table->foreign('cat_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subCategories');

    }
}
