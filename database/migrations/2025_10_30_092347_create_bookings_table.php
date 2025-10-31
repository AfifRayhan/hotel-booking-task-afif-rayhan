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
        $table->string('name');
        $table->string('email');
        $table->string('phone');
        $table->foreignId('room_category_id')->constrained('room_categories')->onDelete('cascade');
        $table->date('from_date');
        $table->date('to_date');
        $table->decimal('base_price', 10, 2);
        $table->decimal('final_price', 10, 2);
        $table->timestamps();
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
