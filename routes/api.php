<?php

use App\Http\Controllers\JWTAuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [JWTAuthController::class, 'register'])->name('auth.register');
    Route::post('/login'   , [JWTAuthController::class, 'login'   ])->name('auth.login');
    Route::get ('/me'      , [JWTAuthController::class, 'me'      ])->name('auth.me');
    Route::post('/refresh' , [JWTAuthController::class, 'refresh' ])->name('auth.refresh');
    Route::post('/logout'  , [JWTAuthController::class, 'logout'  ])->name('auth.logout');
});
