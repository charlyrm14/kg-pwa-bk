<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    UserController,
    ContentController,
    StudentProgressController,
    SwimCategoryController
};

Route::prefix('v1/')->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function() {
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware(['passport.cookie', 'auth:api']);
    });

    Route::prefix('users/')->controller(UserController::class)->group(function() {
        Route::post('', 'store');
        Route::put('{uuid}', 'update');
        Route::put('{uuid}/profile', 'updateProfileInfo');
        Route::put('{uuid}/hobbies', 'updateHobbies');
        Route::delete('{uuid}', 'delete');
    });

    Route::prefix('contents/')->controller(ContentController::class)->group(function() {
        Route::post('', 'store');
    });

    Route::prefix('swim-categories/')->controller(SwimCategoryController::class)->group(function() {
        Route::get('', 'index');
    });

    Route::prefix('student-progress/')->controller(StudentProgressController::class)->group(function() {
        Route::post('', 'assignProgress');
        Route::get('{uuid}', 'dataProgress');
    });

});