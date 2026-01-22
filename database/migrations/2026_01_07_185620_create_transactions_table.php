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
Schema::create('transactions', function (Blueprint $table) {
    $table->id();

    $table->string('tx_ref')->unique();
    $table->string('transaction_id')->unique();

    $table->unsignedBigInteger('product_id')->nullable();
    $table->unsignedBigInteger('seller_id')->nullable();

    $table->string('buyer_email'); // THIS is the identity
    $table->string('buyer_name')->nullable();

    $table->integer('amount');
    $table->string('currency');
    $table->string('status');

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
        Schema::dropIfExists('transactions');
    }
};
