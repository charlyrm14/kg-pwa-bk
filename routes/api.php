<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    UserController,
    ContentController,
    SwimProgramController,
    SwimCategoryController,
    StudentProgramController,
    StudentSkillProgressController,
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
    MediaController,
    AnalyticController
};


Route::prefix('v1/')->group(function () {

    Route::prefix('auth')
        ->controller(AuthController::class)
        ->group(function() {
            Route::post('login', 'login');
            Route::post('logout', 'logout')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('users/')
        ->controller(UserController::class)
        ->group(function() {
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

    Route::get('swim-programs/', SwimProgramController::class);
    Route::get('swim-categories/', SwimCategoryController::class);

    Route::prefix('student-programs/')
        ->controller(StudentProgramController::class)
        ->group(function() {
            Route::post('', 'store');
            Route::get('{user:uuid?}', 'show')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('student-skill-progress/')
        ->controller(StudentSkillProgressController::class)
        ->group(function () {
            Route::patch('{studentSkillProgress}', 'update');
    });

    Route::prefix('schedules/')
        ->controller(ScheduleController::class)
        ->group(function() {
            Route::get('{uuid?}', 'userSchedule')->middleware(['passport.cookie', 'auth:api']);
            Route::put('{user:uuid}', 'assignSchedule');
    });

    Route::prefix('hobbies/')
        ->controller(HobbyController::class)
        ->group(function() {
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

    Route::prefix('attendances/')
        ->controller(AttendanceController::class)
        ->group(function() {
            Route::get('statuses', 'attendanceStatuses');
            Route::get('today', 'todayAttendances');
            Route::get('history/{uuid?}', 'monthlyHistory')->middleware(['passport.cookie', 'auth:api']);
            Route::put('assign/{user:uuid}', 'assignAttendance');
    });

    Route::prefix('reports/')
        ->controller(ReportingController::class)
        ->group(function() {
            Route::post('', 'generate');
    });

    Route::get('overview/user', UserOverviewController::class)->middleware(['passport.cookie', 'auth:api']);

    Route::prefix('chat/')
        ->group(function() {
            Route::post('', [ChatController::class, 'store'])->middleware(['passport.cookie', 'auth:api']);

            Route::prefix('{chat:uuid}/messages')
                ->controller(ChatMessageController::class)
                ->middleware(['passport.cookie', 'auth:api'])
                ->group(function() {
                    Route::get('', 'index');
                    Route::post('', 'store');
            });
    });

    Route::prefix('payments/')
        ->controller(PaymentController::class)
        ->middleware(['passport.cookie', 'auth:api'])
        ->group(function() {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::get('{payment:id}', 'show');
            Route::put('{payment:id}', 'update');
            Route::delete('{payment:id}', 'destroy');
    });

    Route::prefix('rankings/')->group(function() {

        Route::prefix('')
            ->controller(RankingController::class)
            ->group(function() {
                Route::get('', 'index');
        });

        Route::prefix('periods/')
            ->controller(RankingPeriodController::class)
            ->group(function() {
                Route::post('{period:id}/calculate', 'calculate');
                Route::post('{period:id}/publish', 'publish');
        });

        Route::prefix('events/')
            ->controller(RankingEventController::class)
            ->group(function() {
                Route::post('', 'store');
        });
    });

    Route::prefix('notifications/')
        ->controller(NotificationController::class)
        ->middleware(['passport.cookie', 'auth:api'])
        ->group(function() {
            Route::get('', 'index');
            Route::patch('{userNotification}', 'markAsRead');
    });

    Route::prefix('push/')
        ->controller(PushNotificationController::class)
        ->middleware(['passport.cookie', 'auth:api'])
        ->group(function() {
            Route::post('', 'store');
    });

    Route::prefix('media/')
        ->middleware(['passport.cookie', 'auth:api'])
        ->controller(MediaController::class)
        ->group(function() {
            Route::post('', 'store');
            Route::delete('{media}', 'destroy');
    });

    Route::prefix('analytics')
        ->controller(AnalyticController::class)
        ->middleware(['passport.cookie', 'auth:api'])
        ->group(function () {
            Route::get('payments/distribution', 'paymentsDistribution');
            Route::get('attendances/summary', 'attendancesSummary');
            Route::get('users/composition', 'usersComposition');
            Route::get('revenue/timeline', 'revenueTimeline');
    });
});
