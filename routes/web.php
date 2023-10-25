<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('dashboard');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});

Route::group(['namespace' => 'Manage', 'prefix' => 'manage', 'middleware' => ['auth']], function () {

    Route::get('/dashboard', 'MainController@index')->name('dashboard');

    // student presence
    Route::group(['middleware' => ['role:Admin']], function () {
        Route::get('/student/{student}/presence', 'StudentController@presence')->name('student.presence');;
        // student absence 
        Route::get('/student/{student}/absence', 'StudentController@absence')->name('student.absence');;
        // Student Resources
        Route::resource('/student', 'StudentController')->except('create', 'edit');
    });

    // Subject Routes (Admin Middleware)
    Route::group(['middleware' => ['role:Admin']], function () {
        // Go to assign students page for the class
        Route::get('/subject/{subject}/assign', 'SubjectController@assignStudents')->name('subject.assign-student');
        // Store the assigned student to the database
        Route::post('/subject/{subject}/attach', 'SubjectController@attachAssignedStudents')->name('subject.attach-student');
        // Store the assigned student to the database
        Route::delete('/subject/{subject}/detach/{student}', 'SubjectController@detachAssignedStudent')->name('subject.remove.student');
        // Subject Resources
        Route::resource('/subject', 'SubjectController')->except('create', 'edit');
    });


    Route::group(['middleware' => ['role:Admin|User']], function () {
        // Attach students Attendance records
        Route::post('attendance/attach/{attendance}', 'AttendanceController@attachStudents')->name('attendance.attach');
        // Edit students Attendance records
        Route::put('attendance/attach/{attendance}/update', 'AttendanceController@updateAttendanceData')->name('attendance.student.update');
        // Attendance Resources
        Route::resource('attendance', 'AttendanceController');
    });
});

require __DIR__ . '/auth.php';
