<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('plus')->default(0);
            $table->unsignedInteger('minus')->default(0);
            $table->tinyInteger('bath');
            $table->tinyInteger('parking');
            $table->tinyInteger('kitchen');
            $table->tinyInteger('altan');
            $table->tinyInteger('kids');
            $table->unsignedInteger('hotel_type_id');
            $table->double('gps_alt',17,14)->default(23.930185);
            $table->double('gps_lng',17,14)->default(51.496839);
            $table->string('title');
            $table->string('address');
            $table->smallInteger('rooms');
            $table->smallInteger('lux');
            $table->string('about');
            $table->smallInteger('price');
            $table->unsignedInteger('user_id');
            $table->string('foto1')->nullable();
            $table->string('foto2')->nullable();
            $table->string('foto3')->nullable();
            $table->string('foto4')->nullable();
            $table->string('foto5')->nullable();
            $table->tinyInteger('price_type');
            $table->unsignedInteger('to_beach');
            $table->unsignedInteger('to_shop');
            $table->unsignedInteger('to_disco');
            $table->unsignedInteger('to_rest');
            $table->unsignedInteger('to_bus');
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('date_out')->default(null)->nullable();
            $table->timestamp('date_pay')->default(null)->nullable();
            $table->timestamp('date_vip')->default(null)->nullable();
            $table->timestamp('date_top')->default(null)->nullable();
            $table->timestamp('date_up')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
