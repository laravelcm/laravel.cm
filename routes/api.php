<?php

use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\PremiumController;
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

Route::get('replies/{target}', [ReplyController::class, 'all']);
Route::post('replies', [ReplyController::class, 'store']);
Route::put('replies/{id}', [ReplyController::class, 'update']);
Route::post('like/{id}', [ReplyController::class, 'like']);
Route::delete('replies/{id}', [ReplyController::class, 'delete']);

Route::get('premium-users', [PremiumController::class, 'users']);
