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
        //
        Schema::create('bookings', function (Blueprint $table) {
    $table->id();
    $table->string('booking_reference')->unique();
    $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
    $table->string('contact_name');
    $table->string('contact_email');
    $table->string('contact_phone');
    $table->decimal('total_amount', 10, 2);
    $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
