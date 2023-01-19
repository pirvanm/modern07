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
        Schema::create('proposals', function (Blueprint $table) {
            $statuses = App\Enums\ProposalStatuses::toArray();
            $types = App\Enums\ShopTypes::toArray();

            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('created_by');
            $table->enum('type', $types);

            $table->text('note')->nullable();
            $table->json('map')->nullable();

            $table->enum('status', $statuses)->default(App\Enums\ProposalStatuses::NEW->value);

            $table->timestamps();


            //$table->foreign('city_id')->references('id')->on('cities');
            //$table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposals');
    }
};
