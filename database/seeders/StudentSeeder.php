<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    \App\Models\Student::create([
        'name' => 'Yassine Bourachedi',
        'student_id' => '123456', // هذا هو الرقم الذي سنضعه في الـ QR
        'class_name' => 'S4'
    ]);
    }
}
