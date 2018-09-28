<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hotel_id');
            $table->string('title');
            $table->tinyInteger('beds');
            $table->smallInteger('price');
            $table->tinyInteger('price_type');
            $table->string('foto1')->nullable();
            $table->string('foto2')->nullable();
            $table->string('foto3')->nullable();
            $table->string('foto4')->nullable();
            $table->string('foto5')->nullable();
            $table->string('foto6')->nullable();
            $table->string('about')->default('');
            $table->tinyInteger('wc');
            $table->tinyInteger('bath');
            $table->tinyInteger('tv');
            $table->tinyInteger('cond');
            $table->tinyInteger('holo');
            $table->tinyInteger('kitchen');
            $table->tinyInteger('wifi');
            $table->softDeletes();
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
        Schema::dropIfExists('rooms');
    }
}
