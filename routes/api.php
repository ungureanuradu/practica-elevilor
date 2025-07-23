<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

/**  Exemplul standard Jetstream  – lasă-l dacă îți trebuie  */
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/*
|-----------------------------------------------------------
| NEWS ROUTES
|-----------------------------------------------------------
|  - index  (feed)   → PUBLIC
|  - store/update/destroy → PROTEJAT prin Sanctum
*/

/** acces public DOAR la index */
Route::apiResource('news', NewsController::class)->only('index');

/** restul acțiunilor, după autentificare */
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('news', NewsController::class)->except('index');
});
Route::apiResource('events', EventController::class)->only('index');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('events', EventController::class)->except('index');
});
