<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Guest Routes
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
});

// Common Authenticated Routes (Logout)
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->group(function () {
    // manage admins
    Route::get('/admins', [AdminController::class, 'manageAdmin'])->name('admins');
    Route::get('/admin/{id}', [AdminController::class, 'getAdmin'])->name('admin');
    Route::post('/admin', [AdminController::class, 'createAdmin'])->name('admin');
    Route::patch('/admin/{id}', [AdminController::class, 'updateAdminStatus'])->name('.admin');
    Route::put('/admin/{id}', [AdminController::class, 'updateAdmin'])->name('admin');
    Route::delete('/admin/{id}', [AdminController::class, 'deleteAdmin'])->name('admin');
});

Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // manage teachers
    Route::get('/teachers', [AdminController::class, 'manageTeachers'])->name('teachers');
    Route::get('/teacher/{id}', [AdminController::class, 'getTeacher'])->name('teacher');
    Route::post('/teacher', [AdminController::class, 'createTeacher'])->name('teacher');
    Route::patch('/teacher/{id}', [AdminController::class, 'updateTeacherStatus'])->name('teacher');
    Route::put('/teacher/{id}', [AdminController::class, 'updateTeacher'])->name('teacher');
    Route::delete('/teacher/{id}', [AdminController::class, 'deleteTeacher'])->name('teacher');

    // manage students
    Route::get('/students', [AdminController::class, 'manageStudent'])->name('students');
    Route::get('/student/{id}', [AdminController::class, 'getStudent'])->name('student');
    Route::post('/student', [AdminController::class, 'createStudent'])->name('student');
    Route::patch('/student/{id}', [AdminController::class, 'updateStudentStatus'])->name('student');
    Route::put('/student/{id}', [AdminController::class, 'updateStudent'])->name('student');
    Route::delete('/student/{id}', [AdminController::class, 'deleteStudent'])->name('student');
    // manage classes
    Route::get('/classes', [AdminController::class, 'manageClasses'])->name('classes');
    Route::get('/class/{id}', [AdminController::class, 'getClass'])->name('class');
    Route::post('/class', [AdminController::class, 'createClass'])->name('class');
    Route::patch('/class/{id}', [AdminController::class, 'updateStudentStatus'])->name('class');
    Route::put('/class/{id}', [AdminController::class, 'updateStudent'])->name('class');
    Route::delete('/class/{id}', [AdminController::class, 'deleteStudent'])->name('class');
});

// Teacher Routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/courses', [StudentController::class, 'courses'])->name('student.courses');
});
