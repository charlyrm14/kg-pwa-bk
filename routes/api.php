<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/')->group(function () {

    Route::prefix('users/')->controller(UserController::class)->group(function() {
        Route::post('', 'store');
        Route::put('{uuid}/profile', 'updateProfileInfo');
    });

});