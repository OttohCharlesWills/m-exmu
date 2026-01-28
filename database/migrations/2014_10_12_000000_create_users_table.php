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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('phone');
            $table->string('state');

            $table->enum('role', ['admin', 'seller'])->default('seller');

            // 🔥 SELLER SUBSCRIPTION FIELDS
            $table->text('about')->nullable();                     // Seller description
            $table->boolean('is_verified')->default(false);        // Verified after payment/admin
            $table->boolean('is_premium')->default(false);         // Premium subscription
            $table->timestamp('premium_expires_at')->nullable();   // When premium ends

            $table->string('password');
            $table->string('avatar')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
