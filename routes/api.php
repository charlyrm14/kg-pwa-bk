<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    UserController,
    ContentController,
    StudentProgressController,
    SwimCategoryController,
    ScheduleController,
    HobbyController,
    ProfileUserController,
    BirthdayController,
    AttendanceController,
    ReportingController,
    UserOverviewController
};

Route::prefix('v1/')->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function() {
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('users/')->controller(UserController::class)->group(function() {
        Route::get('', 'index');
        Route::post('', 'store');
        Route::put('{uuid}', 'update');
        Route::delete('{uuid}', 'destroy');
    });

    Route::prefix('contents/')->controller(ContentController::class)->group(function() {
        Route::get('', 'index')->middleware(['passport.cookie', 'auth:api']);
        Route::post('', 'store')->middleware(['passport.cookie', 'auth:api']);
        Route::get('{slug}', 'detail')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('swim-categories/')->controller(SwimCategoryController::class)->group(function() {
        Route::get('', 'index');
    });

    Route::prefix('schedules/')->controller(ScheduleController::class)->group(function() {
        Route::get('user', 'userSchedule')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('student-progress/')->controller(StudentProgressController::class)->group(function() {
        Route::get('{uuid?}', 'dataProgress')->middleware(['passport.cookie', 'auth:api']);
        Route::post('', 'assignProgress');
    });

    Route::prefix('hobbies/')->controller(HobbyController::class)->group(function() {
        Route::get('', 'index');
        Route::put('me', 'syncHobbies')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('profile/')->controller(ProfileUserController::class)->middleware(['passport.cookie', 'auth:api'])->group(function() {
        Route::get('', 'show');
        Route::put('', 'update');
    });

    Route::get('birthdays/today', BirthdayController::class);

    Route::prefix('attendances/')->controller(AttendanceController::class)->group(function() {
        Route::get('today', 'todayAttendances');
        Route::get('history/{uuid?}', 'monthlyHistory')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('reports/')->controller(ReportingController::class)->group(function() {
        Route::post('', 'generate');
    });

    Route::get('overview/user', UserOverviewController::class)->middleware(['passport.cookie', 'auth:api']);
});