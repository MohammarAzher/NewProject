<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportController;
use App\Models\Tappa;
use App\Models\Report;
use App\Models\User;


// routes/api.php
use App\Http\Controllers\Api\LiveLocationController;







Route::get('/', function () {
    return  Auth()->user();
});



Route::post('login', [AuthController::class, 'authenticate']);


















Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/live-locations/update', [LiveLocationController::class, 'update']);
});
