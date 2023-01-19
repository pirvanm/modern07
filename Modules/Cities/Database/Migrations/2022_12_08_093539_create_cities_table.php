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
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('county_id')->nullable();
            $table->string('name');
            $table->string('zone_ftn')->nullable();
            $table->string('zone_casa')->nullable();
            $table->enum('status', ['1', '0']);
            $table->integer('siruta')->nullable();
            $table->timestamps();

            //$table->foreign('county_id')->references('id')->on('counties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
