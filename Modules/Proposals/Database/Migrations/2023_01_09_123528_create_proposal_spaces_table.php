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
        Schema::create('proposal_spaces', function (Blueprint $table) {
            $shopTypes = App\Enums\ShopTypes::toArray();
            $streeTypes = App\Enums\StreetTypes::toArray();

            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->enum('agency_type', $shopTypes);
            $table->string('space_type')->nullable();
            $table->string('total_area')->nullable();
            $table->string('area_annexes')->nullable();
            $table->string('street_front')->nullable();
            $table->string('floor')->nullable();
            $table->enum('street_type', $streeTypes)->nullable();
            $table->integer('grade')->nullable();
            $table->boolean('bathroom')->default(0);

            $table->string('company_agency')->nullable();
            $table->timestamps();

            // add foreign key here
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_spaces');
    }
};
