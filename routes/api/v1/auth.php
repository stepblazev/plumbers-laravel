<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Middleware\Api\Authenticate;

Route::prefix('v1')->group(function () {
    
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(Authenticate::ALIAS);
    Route::post('/user', [AuthController::class, 'user'])->middleware(Authenticate::ALIAS);

});
