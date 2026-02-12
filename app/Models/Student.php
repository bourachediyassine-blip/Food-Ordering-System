<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // أضفنا type و balance هنا لكي يسمح النظام بحفظهما في قاعدة البيانات
    protected $fillable = [
        'student_id', 
        'name', 
        'class_name', 
        'type', 
        'balance', 
        'last_meal_at'
    ];
}
