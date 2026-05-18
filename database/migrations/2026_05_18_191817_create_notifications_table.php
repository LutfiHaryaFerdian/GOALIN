<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('booking_id')
                ->nullable()
                ->constrained('bookings')
                ->nullOnDelete();

            // Tipe notifikasi untuk menentukan tampilan/ikon di frontend
            $table->enum('type', [
                'booking_pending',      // Pemesanan masuk, menunggu konfirmasi
                'booking_confirmed',    // Pemesanan dikonfirmasi
                'booking_cancelled',    // Pemesanan dibatalkan
                'booking_completed',    // Pemesanan selesai
                'payment_reminder',     // Pengingat pembayaran
                'system',               // Notifikasi umum dari sistem
            ]);

            $table->string('title');
            $table->text('message');
            $table->timestamp('read_at')->nullable(); // Null = belum dibaca
            $table->timestamps();

            $table->index(['user_id', 'read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
