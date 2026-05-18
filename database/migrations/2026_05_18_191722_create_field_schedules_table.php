<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')
                ->constrained('fields')
                ->cascadeOnDelete();
            $table->date('schedule_date');       // Tanggal slot tersedia
            $table->time('start_time');          // Jam mulai  (contoh: 08:00:00)
            $table->time('end_time');            // Jam selesai (contoh: 09:00:00)
            $table->enum('status', [
                'available',   // Bisa dipesan
                'booked',      // Sudah dipesan
                'closed',      // Ditutup oleh admin/owner
            ])->default('available');
            $table->text('notes')->nullable();   // Catatan dari owner jika closed
            $table->timestamps();

            // Mencegah slot waktu yang sama pada lapangan dan tanggal yang sama
            // Ini adalah kunci utama pencegahan double booking
            $table->unique(['field_id', 'schedule_date', 'start_time'], 'unique_field_schedule_slot');

            $table->index(['field_id', 'schedule_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_schedules');
    }
};
