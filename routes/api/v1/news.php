<?php

use App\Http\Controllers\Api\v1\News\NewsController;

Route::prefix('v1')->group(function () {
    
    Route::get('/news', [NewsController::class, 'get']);
    Route::post('/news', [NewsController::class, 'create']);
    Route::delete('/news', [NewsController::class, 'delete']);
    
});
