<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('field_id')
                ->constrained('fields')
                ->restrictOnDelete();
            $table->foreignId('schedule_id')
                ->constrained('field_schedules')
                ->restrictOnDelete();

            // Kode unik pemesanan, contoh: GOAL-20260519-A3X9
            $table->string('booking_code', 30)->unique();

            $table->date('booking_date');        // Tanggal lapangan dipesan
            $table->time('start_time');          // Jam mulai
            $table->time('end_time');            // Jam selesai
            $table->decimal('total_price', 10, 2);

            $table->enum('status', [
                'pending',     // Menunggu konfirmasi owner/admin
                'confirmed',   // Dikonfirmasi
                'cancelled',   // Dibatalkan
                'completed',   // Selesai digunakan
            ])->default('pending');

            $table->enum('payment_status', [
                'unpaid',      // Belum bayar
                'paid',        // Sudah bayar
                'refunded',    // Dana dikembalikan (jika cancel)
            ])->default('unpaid');

            $table->text('notes')->nullable();           // Catatan dari pemesan
            $table->text('cancellation_reason')->nullable(); // Alasan pembatalan
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['field_id', 'booking_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
