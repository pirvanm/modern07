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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hris_code')->nullable();
            $table->string('cui', 12);
            $table->string('reg');
            $table->unsignedBigInteger('city_id');
            $table->string('phone');
            $table->string('email');
            $table->string('abbr')->nullable();
            $table->enum('type', ['OWN', 'PARTNER']);
            $table->enum('status', ['0', '1']);
            $table->timestamps();

            //$table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
