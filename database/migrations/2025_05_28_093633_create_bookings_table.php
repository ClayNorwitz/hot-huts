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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('timeslot_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('people');                         // 1–8
            $table->enum('status', ['pending', 'paid', 'cancelled'])
                ->default('pending');
            $table->decimal('amount', 8, 2);
            $table->timestamps();
            $table->unique(['user_id', 'timeslot_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
