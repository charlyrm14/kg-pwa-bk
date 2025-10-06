<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    ContentController
};

Route::prefix('v1/')->group(function () {

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
});