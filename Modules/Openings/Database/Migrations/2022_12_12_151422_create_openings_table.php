<?php

use App\Enums\OpeningStatuses;
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
        Schema::create('openings', function (Blueprint $table) {
            $statuses = OpeningStatuses::toArray();
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->enum('status', $statuses)->default(OpeningStatuses::NEW->value);
            $table->timestamps();

            //$table->foreign('proposal_id')->references('proposals')->on('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('openings');
    }
};
