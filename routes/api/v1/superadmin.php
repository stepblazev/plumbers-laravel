<?php

use App\Http\Controllers\Api\v1\Admin\AdminController;
use App\Http\Middleware\SuperadminOnly;

Route::prefix('v1')->group(function () {
    Route::prefix('superadmin')->middleware(SuperadminOnly::ALIAS)->group(function () {
        
        Route::post('/admin', [AdminController::class, 'create']);
        // Route::get('/admin', [AdminController::class, 'get']);
        // Route::delete('/admin', [AdminController::class, 'delete']);
        // Route::update('/admin', [AdminController::class, 'update']);
        
    });
});
