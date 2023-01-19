<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->enum('status', ['in deschidere', 'deschisa', 'suspendata', 'sezoniera', 'reamenajare', 'in inchidere', 'inchisa', 'retrasa']);
            $table->enum('type', ['FTN OWN', 'FTN JV', 'FTN JV2', 'CASA OWN', 'CASA JV', 'FTN SSBT', 'CASA SSBT']);
            $table->enum('slots_types', ['OS', 'TS', 'NS']);
            $table->dateTime('opened_at');
            $table->dateTime('closed_at');
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
        Schema::dropIfExists('shops');
    }
};
