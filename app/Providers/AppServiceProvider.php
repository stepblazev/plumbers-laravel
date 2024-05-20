<?php

namespace App\Providers;

use App\Http\Responses\ApiResponse;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $response = app(ResponseFactory::class);
        $response->macro('api', function($data = null, $status = 200, $headers = []) {
           return new ApiResponse($data, $status, $headers); 
        });
    }
}
