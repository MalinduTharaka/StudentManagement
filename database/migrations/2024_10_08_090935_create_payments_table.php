<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Assuming you have a courses table
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assuming you have a users table
            $table->decimal('amount', 10, 2)->default(10000); // The payment amount
            $table->string('payment_method'); // Method of payment (e.g., card, bank draft)
            $table->string('payment_slip')->nullable(); // Path to payment slip if applicable
            $table->enum('status', ['pending', 'verified', 'failed'])->default('pending'); // Payment status
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
