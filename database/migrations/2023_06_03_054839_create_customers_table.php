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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('email')->unique();
            $table->text('password');
            $table->text('phone')->nullable();
            $table->text('country')->nullable();
            $table->text('address')->nullable();
            $table->text('state')->nullable();
            $table->text('city')->nullable();
            $table->text('zip')->nullable();
            $table->text('photo')->nullable();
            $table->text('token')->nullable();
            $table->text('status')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};