<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\FavouriteMusicController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LanguageController;
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

Route::post('episodeViewCount', [EpisodeController::class, 'episodeViewCount']);
Route::post('episodeDownloadCount', [EpisodeController::class, 'episodeDownloadCount']);

// Add User
Route::post('addUser', [UserController::class, 'addUser']);

// Search Content
Route::post('searchContent', [ContentController::class, 'searchContent']);

// Fetch Content
Route::post('fetchContentType', [ContentController::class, 'fetchContentType']);
Route::post('fetchContent', [ContentController::class, 'fetchContent']);
Route::post('fetchSeriesContent', [ContentController::class, 'fetchSeriesContent']);

// Fetch Featured item
Route::post('fetchFeaturedItem', [ContentController::class, 'fetchFeaturedItem']);

// Fetch ContentByGenre
// Route::post('contentByGenre', [ContentController::class, 'contentByGenre']);

// Fetch Content By Language
Route::post('contentByLanguage', [LanguageController::class, 'contentByLanguage']);
