<?php

use App\Http\Controllers\Api\CarBookController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResources([
    'users' => UserController::class,
    'cars' => CarController::class
]);

Route::prefix('book/cars')->group(function() {
    Route::post('/', [CarBookController::class, 'book']);
    Route::delete('/', [CarBookController::class, 'deleteBook']);
});

Route::get('/users/{id}/car', [UserController::class, 'getCar']);
