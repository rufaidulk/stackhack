<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::fallback(function() {
    return response()->json([
        'status' => Response::HTTP_NOT_FOUND,
        'message' => Response::$statusTexts[Response::HTTP_NOT_FOUND],
        'errors' => 'Page not found'
    ], Response::HTTP_NOT_FOUND);
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'Api\AuthController@register');
    Route::post('login', 'Api\AuthController@login');
});

Route::apiResource('tasks', 'Api\TaskController');
