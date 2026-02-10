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
    UserOverviewController,
    ChatController,
    ChatMessageController,
    PaymentController,
    RankingController,
    RankingPeriodController,
    RankingEventController,
    NotificationController,
    PushNotificationController,
    MediaController
};

Route::prefix('v1/')->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function() {
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('users/')->controller(UserController::class)->group(function() {
        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('{user:uuid}', 'show');
        Route::put('{uuid}', 'update');
        Route::delete('{uuid}', 'destroy');
    });

    Route::prefix('contents/')
        ->controller(ContentController::class)
        ->middleware(['passport.cookie', 'auth:api'])
        ->group(function() {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::get('{slug}', 'show');
            Route::delete('{content:slug}', 'destroy');
    });

    Route::prefix('swim-categories/')->controller(SwimCategoryController::class)->group(function() {
        Route::get('', 'index');
    });

    Route::prefix('schedules/')->controller(ScheduleController::class)->group(function() {
        Route::get('{uuid?}', 'userSchedule')->middleware(['passport.cookie', 'auth:api']);
        Route::put('{user:uuid}', 'assignSchedule');
    });

    Route::prefix('student-progress/')->controller(StudentProgressController::class)->group(function() {
        Route::get('{uuid?}', 'dataProgress')->middleware(['passport.cookie', 'auth:api']);
        Route::post('', 'assignProgress');
    });

    Route::prefix('hobbies/')->controller(HobbyController::class)->group(function() {
        Route::get('', 'index');
        Route::put('me', 'syncHobbies')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('profile/')
        ->controller(ProfileUserController::class)
        ->middleware(['passport.cookie', 'auth:api'])
        ->group(function() {
            Route::get('', 'show');
            Route::put('', 'update');
    });

    Route::get('birthdays/today', BirthdayController::class);

    Route::prefix('attendances/')->controller(AttendanceController::class)->group(function() {
        Route::get('statuses', 'attendanceStatuses');
        Route::get('today', 'todayAttendances');
        Route::get('history/{uuid?}', 'monthlyHistory')->middleware(['passport.cookie', 'auth:api']);
        Route::put('assign/{user:uuid}', 'assignAttendance');
    });

    Route::prefix('reports/')->controller(ReportingController::class)->group(function() {
        Route::post('', 'generate');
    });

    Route::get('overview/user', UserOverviewController::class)->middleware(['passport.cookie', 'auth:api']);

    Route::prefix('chat/')->group(function() {
        Route::post('', [ChatController::class, 'store'])->middleware(['passport.cookie', 'auth:api']);

        Route::prefix('{chat:uuid}/messages')->controller(ChatMessageController::class)->group(function() {
            Route::get('', 'index')->middleware(['passport.cookie', 'auth:api']);
            Route::post('', 'store')->middleware(['passport.cookie', 'auth:api']);
        });
    });

    Route::prefix('payments/')
        ->controller(PaymentController::class)
        ->middleware(['passport.cookie', 'auth:api'])
        ->group(function() {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('{payment:id}', 'update');
            Route::delete('{payment:id}', 'destroy');
    });

    Route::prefix('rankings/')->group(function() { 

        Route::prefix('')->controller(RankingController::class)->group(function() { 
            Route::get('', 'index');
        }); 

        Route::prefix('periods/')->controller(RankingPeriodController::class)->group(function() { 
            Route::post('{period:id}/calculate', 'calculate');
            Route::post('{period:id}/publish', 'publish'); 
        }); 

        Route::prefix('events/')->controller(RankingEventController::class)->group(function() { 
            Route::post('', 'store'); 
        }); 
    });

    Route::prefix('notifications/')->controller(NotificationController::class)->group(function() {
        Route::get('', 'index')->middleware(['passport.cookie', 'auth:api']);
        Route::patch('{userNotification}', 'markAsRead')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('push/')->controller(PushNotificationController::class)->group(function() {
        Route::post('', 'store')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('media/')->controller(MediaController::class)->group(function() {
        Route::post('', 'store')->middleware(['passport.cookie', 'auth:api']);
        Route::delete('{media}', 'destroy')->middleware(['passport.cookie', 'auth:api']);
    });
});