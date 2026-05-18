<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('field_id')
                ->constrained('fields')
                ->restrictOnDelete();
            $table->foreignId('booking_id')
                ->constrained('bookings')
                ->restrictOnDelete();

            $table->tinyInteger('rating');       // Nilai 1 - 5
            $table->text('comment')->nullable();
            $table->timestamps();

            // Satu booking hanya boleh memberikan satu ulasan
            $table->unique('booking_id', 'unique_review_per_booking');

            $table->index(['field_id', 'rating']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
