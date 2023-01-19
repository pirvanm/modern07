<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_competitions', function (Blueprint $table) {

            $competitors = App\Enums\Competitors::toArray();
            $table->id();

            $table->enum('name', $competitors)->default(App\Enums\Competitors::UNKNOWN->value);
            $table->integer('distance')->nullable();
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
        Schema::dropIfExists('proposal_competions');
    }
};
