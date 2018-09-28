<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaidSchemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_schemes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ptype_id')->unsigned();
            $table->string('name');
            $table->unsignedSmallInteger('days');
            $table->unsignedSmallInteger('price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paid_schemes');
    }
}
