<?php

namespace App\Ab;

use Illuminate\Support\Facades\Route;

// Application Routes Controllers 

use App\Ab\User\Controller\UserController;
use App\Ab\Employee\Controller\EmployeeController;


Route::get('/', function () {
    return 'Hello AB Team';
});


Route::controller(UserController::class)->group(function () {

    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/user/token', 'token');
    Route::post('/forgot-password', 'forgotPassword');

});


Route::middleware('auth:sanctum')->group(function () {

    Route::controller(UserController::class)->group(function () {

        Route::post('/logout', 'logout');
     
        Route::get('/user', 'index');
    });


    Route::controller(EmployeeController::class)->group(function () {

        Route::get('/employee/all', 'index');
        Route::post('/employee/new', 'store');
        Route::get('/employee/get/{id}', 'show');
        Route::post('/employee/update/{id}', 'update');
        Route::post('/employee/delete/{id}', 'destroy');
        Route::get('/employee/{id}/attendance/all', 'allAttendance');
        Route::post('/employee/{id}/attendance/new', 'attendanceStore');
        Route::post('/employee/{id}/attendance/{attendanceId}', 'attendanceUpdate');
        Route::delete('/employee/{id}/attendance/{attendanceId}', 'attendanceDestroy');

        Route::get('/employee/deail-attendace-report-in-pdf', 'daylyAttendanceReportInPdf');
        Route::get('/employee/deail-attendace-report-in-excel', 'daylyAttendanceReportInExcel');



    });
});
