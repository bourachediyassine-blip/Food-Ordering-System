<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); 
            $table->timestamps(); // سنستخدم created_at بدلاً من scan_date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_logs');
    }
};