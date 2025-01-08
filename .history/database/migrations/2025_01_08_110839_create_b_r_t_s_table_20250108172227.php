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
        Schema::create('brts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('brt_code')->unique();  // Ensure brt_code is unique
            $table->decimal('reserved_amount', 10, 2)->nullable();  // Make reserved_amount nullable if needed
            $table->enum('status', ['active', 'expired'])->default('active');  // Default 'active' status
            $table->timestamps();

            // Foreign key constraint to the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brts');
    }
};
