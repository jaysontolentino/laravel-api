<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;

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

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);

Route::get('auth-user', [AccountController::class, 'me'])->middleware(['auth:sanctum']);

Route::post('revoke-tokens', [AccountController::class, 'revokeTokens'])->middleware(['auth:sanctum']);

Route::apiResource('users', UserController::class)->middleware(['auth:sanctum', 'ability:admin']);