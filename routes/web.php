<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'checkSuspended'])->group(function () {
    // Public Route
    Route::get('/', function () {
        return view('welcome');
    });

    // Dashboard Route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users/{user}/role', [App\Http\Controllers\Admin\UserController::class, 'changeRole'])->name('admin.users.changeRole');
        Route::post('/admin/users/{user}/suspend', [App\Http\Controllers\Admin\UserController::class, 'suspendUser'])->name('admin.users.suspend');
        Route::post('/admin/users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('admin.users.resetPassword');
    });

    // Staff Routes
    Route::middleware('role:staff')->group(function () {
        Route::get('/staff/dashboard', function () {
            return view('staff.dashboard');
        })->name('staff.dashboard');
    });

    // Student Routes
    Route::middleware('role:student')->group(function () {
        Route::get('/student/dashboard', function () {
            return view('student.dashboard');
        })->name('student.dashboard');
    });

    // User Routes
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');
    });

    // Course and Lesson Routes (Admin and Staff)
    Route::middleware(['role:admin,staff'])->group(function () {
        Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);

        Route::get('/courses/{course}/add-lesson', [App\Http\Controllers\Admin\LessonController::class, 'create'])->name('courses.addLesson');
        Route::post('/courses/{course}/add-lesson', [App\Http\Controllers\Admin\LessonController::class, 'store'])->name('courses.storeLesson');
        Route::get('/courses/{course}/lessons', [App\Http\Controllers\Admin\LessonController::class, 'index'])->name('courses.showLessons');
        Route::get('/lessons/{lesson}/edit', [App\Http\Controllers\Admin\LessonController::class, 'edit'])->name('lessons.edit');
        Route::delete('/lessons/{lesson}', [App\Http\Controllers\Admin\LessonController::class, 'destroy'])->name('lessons.destroy');
        Route::put('/lessons/{lesson}', [App\Http\Controllers\Admin\LessonController::class, 'update'])->name('lessons.update');
        Route::get('/lessons/trash', [App\Http\Controllers\Admin\LessonController::class, 'trash'])->name('lessons.trash');
        Route::post('/lessons/{lesson}/restore', [App\Http\Controllers\Admin\LessonController::class, 'restore'])->name('lessons.restore');
        Route::get('/courses/{course}', [App\Http\Controllers\Admin\CourseController::class, 'show'])->name('courses.show');

        // Available Courses Route
        Route::get('/available', [App\Http\Controllers\Admin\CourseController::class, 'available'])->name('courses.available');
        Route::get('courses/{id}/enroll', [App\Http\Controllers\Admin\CourseController::class, 'enroll'])->name('courses.enroll');
        Route::post('courses/{id}/payment', [App\Http\Controllers\Admin\CourseController::class, 'storePayment'])->name('courses.storePayment');

        Route::get('/enroll-requests', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('enroll.requests');
        Route::post('/enroll-approve/{id}', [App\Http\Controllers\Admin\PaymentController::class, 'approve'])->name('enroll.approve');
        Route::post('/enroll-deny/{id}', [App\Http\Controllers\Admin\PaymentController::class, 'deny'])->name('enroll.deny');




    });


});

// Route for suspended users
Route::get('/suspended', function () {
    return view('auth.suspended');
})->name('suspended');
