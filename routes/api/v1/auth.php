<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Middleware\AuthenticateAPI;
use App\Http\Middleware\SuperadminOnly;

Route::prefix('v1')->group(function () {
    
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(AuthenticateAPI::ALIAS);
    Route::post('/user', [AuthController::class, 'user'])->middleware(AuthenticateAPI::ALIAS);

});
