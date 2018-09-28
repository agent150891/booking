<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignHotels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->foreign('user_id','FK_hotels__users')->references('id')->on('users');
            $table->foreign('city_id','FK_hotels__cities')->references('id')->on('cities');
            $table->foreign('hotel_type_id','FK_hotels__hotel_types')->references('id')->on('hotel_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropForeign('FK_hotels__users');
            $table->dropForeign('FK_hotels__cities');
            $table->dropForeign('FK_hotels__hotel_types');
        });
    }
}
