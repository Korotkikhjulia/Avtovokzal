<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [MainController::class, 'register']);
Route::post('/login', [MainController::class, 'login']);
Route::get('/bus/{id}', [MainController::class, 'show']);
Route::get('/bus', [MainController::class, 'index']);
Route::get('/route/{id}', [MainController::class, 'route']);
Route::get('/route', [MainController::class, 'route2']);
Route::get('/auth', [MainController::class, 'auth']);
Route::group(['middleware' => ['auth', 'isdispatcher']], function () {
    Route::get('/logout', [MainController::class, 'logout']);
    Route::post('/route', [MainController::class, 'store']);
    Route::put('/route', [MainController::class, 'update']);
    Route::delete('/route', [MainController::class, 'destroy']);
    Route::post('/bus', [MainController::class, 'bstore']);
    Route::put('/bus', [MainController::class, 'bupdate']);
    Route::delete('/bus', [MainController::class, 'bdestroy']);
});
Route::group(['middleware' => ['auth', 'isadmin']], function () {
    Route::post('/user', [MainController::class, 'ustore']);
    Route::put('/user', [MainController::class, 'uupdate']);
    Route::put('/password', [MainController::class, 'password']);
    Route::delete('/user', [MainController::class, 'udestroy']);
    Route::get('/user', [MainController::class, 'user']);
});


