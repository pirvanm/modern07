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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->unsignedBigInteger('company_id');
            $table->string('phone');
            $table->string('email');
            $table->enum('type', ['0', '1'])->default(0);
            $table->enum('status', ['1', '0']);
            $table->timestamps();

            //$table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partners');
    }
};
