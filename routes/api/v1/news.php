<?php

use App\Http\Controllers\Api\v1\News\NewsController;
use App\Http\Middleware\Api\Authenticate;
use App\Http\Middleware\Api\CompanyOnly;
use App\Http\Middleware\Api\NewsControl;

Route::prefix('v1')
    ->middleware([Authenticate::ALIAS, CompanyOnly::ALIAS])
    ->group(function () {
    
        Route::get('/news', [NewsController::class, 'get']);
        Route::post('/news', [NewsController::class, 'create'])->middleware(NewsControl::ALIAS);
        Route::delete('/news/{id}', [NewsController::class, 'delete'])->middleware(NewsControl::ALIAS);
    
});
