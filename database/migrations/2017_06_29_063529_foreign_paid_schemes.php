<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignPaidSchemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paid_schemes', function (Blueprint $table) {
            $table->foreign('ptype_id','FK_paid_schemes__paid_types')->references('id')->on('paid_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paid_schemes', function (Blueprint $table) {
            $table->dropForeign('FK_paid_schemes__paid_types');
        });
    }
}
