<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id'); // Sender (User or Admin)
            $table->unsignedBigInteger('receiver_id')->nullable(); // Receiver (Admin or User)
            $table->string('brt_code');
            $table->decimal('reserved_amount', 8, 2);
            $table->enum('status', ['active', 'expired', 'pending']);
            $table->timestamps();

            // Foreign keys
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
