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
        Schema::create('buses', function (Blueprint $table) {
    $table->id();
    $table->string('name');               // e.g. "Royal Eagle"
    $table->string('plate_number')->unique();
    $table->integer('capacity');
    $table->enum('type', ['minibus', 'bus']);
    $table->string('company_name');       // e.g. "Mazhandu Family"
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
