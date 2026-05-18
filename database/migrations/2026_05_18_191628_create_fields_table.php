<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('field_categories')
                ->restrictOnDelete();
            $table->foreignId('location_id')
                ->constrained('locations')
                ->restrictOnDelete();
            $table->foreignId('owner_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->string('name');                          // Nama lapangan
            $table->string('slug')->unique();                // Untuk URL
            $table->text('description')->nullable();
            $table->decimal('price_per_hour', 10, 2);       // Harga per jam
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->json('facilities')->nullable();          // ["parkir","toilet","mushola","wifi"]
            $table->json('images')->nullable();              // Array path foto lapangan
            $table->integer('capacity')->default(1);        // Kapasitas pemain
            $table->timestamps();

            $table->index(['category_id', 'status']);
            $table->index(['location_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
