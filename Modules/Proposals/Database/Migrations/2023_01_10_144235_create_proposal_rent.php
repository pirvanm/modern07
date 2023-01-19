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
        Schema::create('proposal_rents', function (Blueprint $table) {
            $paymentTypes = App\Enums\PaymentType::toArray();

            $table->id();
            $table->unsignedBigInteger('proposal_id');

            $table->integer('price')->nullable();
            $table->string('currency')->nullable();
            $table->enum('payment_type', $paymentTypes)->default(App\Enums\PaymentType::UNKNOWN->value);

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
        Schema::dropIfExists('proposal_rent');
    }
};
