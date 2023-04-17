<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string("avatar", 50)->nullable();
            $table->string('address_street', 50)->nullable();
            $table->string('address_appartment', 30)->nullable();
            $table->string('address_town', 50)->nullable();
            $table->string('address_state', 50)->nullable();
            $table->string('address_country', 50)->nullable();
            $table->string('address_postcode', 6)->nullable();
            $table->string('phone', 12)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
