<?php

use App\Http\Controllers\Api\v1\Admin\AdminController;
use App\Http\Middleware\Api\SuperadminOnly;

Route::prefix('v1')->group(function () {
    Route::prefix('superadmin')->middleware(SuperadminOnly::ALIAS)->group(function () {
        
        // получение списка админов (по фильтру) или детального админа 
        Route::get('/admin', [AdminController::class, 'filtered']);
        Route::get('/admin/{id}', [AdminController::class, 'detail']);
        
        // создание нового админа и компании для него
        Route::post('/admin', [AdminController::class, 'create']);
        
        // обновление и удаление админа
        Route::put('/admin/{id}', [AdminController::class, 'update']);
        Route::delete('/admin/{id}', [AdminController::class, 'delete']);
        
    });
});
