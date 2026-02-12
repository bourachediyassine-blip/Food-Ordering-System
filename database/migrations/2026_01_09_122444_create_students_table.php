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
       Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // اسم الشخص
            $table->string('student_id')->unique(); // الرقم الفريد (QR Code)
            
            // التعديل: جعل القسم اختيارياً (nullable) لأنه لا يوجد قسم للعمال
            $table->string('class_name')->nullable(); 
            
            // الإضافة: نوع العضو (تلميذ أو عامل)
            $table->string('type')->default('student'); 
            
            // الإضافة: الرصيد (افتراضياً 0 ويقبل أن يكون فارغاً)
            $table->decimal('balance', 10, 2)->default(0)->nullable(); 
            
            // الإضافة: تاريخ آخر وجبة (للتأكد من عدم التكرار)
            $table->timestamp('last_meal_at')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};