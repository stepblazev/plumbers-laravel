<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

$version = config('app.api_version');

require_once "api/$version/auth.php";
require_once "api/$version/superadmin.php";
require_once "api/$version/news.php";