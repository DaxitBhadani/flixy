<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavouriteMusicController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\TvChannelController;
use App\Http\Controllers\UserController;
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

Route::post('test', [TvChannelController::class,'test']);


Route::post('viewCount', [SourceController::class, 'viewCount']);
Route::post('shareCount', [SourceController::class, 'shareCount']);
Route::post('downloadCount', [SourceController::class, 'downloadCount']);