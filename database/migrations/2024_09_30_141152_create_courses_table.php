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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('original_price', 8, 2);
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->boolean('installment')->default(false);
            $table->decimal('installment_1', 8, 2)->nullable();
            $table->decimal('installment_2', 8, 2)->nullable();
            $table->decimal('installment_3', 8, 2)->nullable();
            $table->decimal('installment_4', 8, 2)->nullable();
            $table->decimal('installment_5', 8, 2)->nullable();
            $table->decimal('installment_6', 8, 2)->nullable();
            $table->date('start_date');
            $table->string('duration');
            $table->enum('status', ['ongoing', 'complete', 'waiting', 'deleted'])->default('waiting');
            $table->string('image')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
