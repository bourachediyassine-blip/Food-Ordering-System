<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

// 1. الواجهة الرئيسية (بدون كلمة سر)
Route::get('/', function () { 
    return view('home'); 
})->name('home');

// 2. واجهة السكنر (بدون كلمة سر - متاحة للطلاب والعمال)
Route::get('/scan', [StudentController::class, 'showScanPage'])->name('scan');
Route::post('/scan/process', [StudentController::class, 'processScan'])->name('scan.process');

// 3. لوحة التحكم (Admin) - رابط واحد يدير الفرز بكلمة سر داخلية (كما في تصميمك)
Route::prefix('admin')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('students.index');
    Route::post('/store', [StudentController::class, 'store'])->name('students.store');
    Route::put('/update/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/destroy/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
});

// 4. تسجيل الخروج
Route::get('/logout', function () {
    return redirect()->route('home');
})->name('logout');