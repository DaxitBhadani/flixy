<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CastController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\TvCategoryController;
use App\Http\Controllers\TvChannelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('doLogin',[AuthController::class,'doLogin'])->name('doLogin');

Route::get('login', [AuthController::class,'login'])->name('login');
Route::get('logout', [AuthController::class,'logout'])->name('logout');


Route::get('/index', [MainController::class, 'index'])->middleware(['checkLogin'])->name('index');


Route::get('language', [LanguageController::class, 'language'])->middleware(['checkLogin']);
Route::post('storeLanguage', [LanguageController::class, 'storeLanguage'])->middleware(['checkLogin']);
Route::post('fetchLanguageList', [LanguageController::class, 'fetchLanguageList'])->middleware(['checkLogin']);
Route::post('updateLanguage/{id}', [LanguageController::class, 'updateLanguage'])->middleware(['checkLogin']);
Route::post('deleteLanguage/{id}', [LanguageController::class, 'deleteLanguage'])->middleware(['checkLogin']);


Route::get('genre', [GenreController::class, 'genre'])->middleware(['checkLogin']) ;
Route::post('storeGenre', [GenreController::class, 'storeGenre'])->middleware(['checkLogin']) ;
Route::post('fetchGenreList', [GenreController::class, 'fetchGenreList'])->middleware(['checkLogin']) ;
Route::post('updateGenre/{id}', [GenreController::class, 'updateGenre'])->middleware(['checkLogin']) ;
Route::post('deleteGenre/{id}', [GenreController::class, 'deleteGenre'])->middleware(['checkLogin']) ;


Route::get('actors', [ActorController::class, 'actors'])->middleware(['checkLogin']) ;
Route::post('storeActor', [ActorController::class, 'storeActor'])->middleware(['checkLogin']) ;
Route::post('fetchActorList', [ActorController::class, 'fetchActorList'])->middleware(['checkLogin']) ;
Route::post('updateActor/{id}', [ActorController::class, 'updateActor'])->middleware(['checkLogin']) ;
Route::post('deleteActor/{id}', [ActorController::class, 'deleteActor'])->middleware(['checkLogin']) ;


Route::get('tvCategory', [TvCategoryController::class, 'tvCategory'])->middleware(['checkLogin']) ;
Route::post('storeTvCategory', [TvCategoryController::class, 'storeTvCategory'])->middleware(['checkLogin']) ;
Route::post('fetchTvCategoryList', [TvCategoryController::class, 'fetchTvCategoryList'])->middleware(['checkLogin']) ;
Route::post('updateTvCategory/{id}', [TvCategoryController::class, 'updateTvCategory'])->middleware(['checkLogin']) ;
Route::post('deleteTvCategory/{id}', [TvCategoryController::class, 'deleteTvCategory'])->middleware(['checkLogin']) ;


Route::get('tvChannel', [TvChannelController::class, 'tvChannel'])->middleware(['checkLogin']) ;
Route::post('storeTvChannel', [TvChannelController::class, 'storeTvChannel'])->middleware(['checkLogin']) ;
Route::post('fetchTvChannelList', [TvChannelController::class, 'fetchTvChannelList'])->middleware(['checkLogin']) ;
Route::post('updateTvChannel/{id}', [TvChannelController::class, 'updateTvChannel'])->middleware(['checkLogin']) ;
Route::post('deleteTvChannel/{id}', [TvChannelController::class, 'deleteTvChannel'])->middleware(['checkLogin']) ;

// Route::get('test', [TvChannelController::class, 'test'])->middleware(['checkLogin']) ;

Route::get('contentList', [ContentController::class, 'contentList'])->middleware(['checkLogin']) ;
Route::post('storeNewContent', [ContentController::class, 'storeNewContent'])->middleware(['checkLogin']) ;
Route::post('fetchContentList', [ContentController::class, 'fetchContentList'])->middleware(['checkLogin']) ;
Route::post('updateContent/{id}', [ContentController::class, 'updateContent'])->middleware(['checkLogin']) ;
Route::post('deleteContent/{id}', [ContentController::class, 'deleteContent'])->middleware(['checkLogin']) ;

Route::post('fetchContentSeries', [ContentController::class, 'fetchContentSeries'])->middleware(['checkLogin']) ;

Route::get('contentList/{id}', [SourceController::class, 'contentListEdit'])->middleware(['checkLogin']);
Route::post('addSource', [SourceController::class, 'storeNewSource'])->middleware(['checkLogin']);
Route::post('contentList/sourceList', [SourceController::class, 'sourceList'])->middleware(['checkLogin']);
Route::post('updateSource/{id}', [SourceController::class, 'updateSource'])->middleware(['checkLogin']);
Route::post('deleteSource/{id}', [SourceController::class, 'deleteSource'])->middleware(['checkLogin']);


Route::post('storeNewCast', [SourceController::class, 'storeNewCast'])->middleware(['checkLogin']);
Route::post('contentList/castList', [SourceController::class, 'castList'])->middleware(['checkLogin']);
Route::post('updateCast/{id}', [SourceController::class, 'updateCast'])->middleware(['checkLogin']);
Route::post('deleteCast/{id}', [SourceController::class, 'deleteCast'])->middleware(['checkLogin']);

Route::post('storeSubtitle', [SourceController::class, 'storeSubtitle'])->middleware(['checkLogin']);
Route::post('contentList/SubtitleList', [SourceController::class, 'SubtitleList'])->middleware(['checkLogin']);
Route::post('deleteSubtitle/{id}', [SourceController::class, 'deleteSubtitle'])->middleware(['checkLogin']);


Route::get('contentList/series/{id}', [SeriesController::class, 'seriesList'])->middleware(['checkLogin']);
Route::post('addSeason', [SeriesController::class, 'addSeason']);
Route::post('updateSeason/{id}', [SeriesController::class, 'updateSeason'])->middleware(['checkLogin']);
Route::post('deleteSeason/{id}', [SeriesController::class, 'deleteSeason'])->middleware(['checkLogin']);

Route::post('addEpisode', [EpisodeController::class, 'addEpisode']);
Route::post('fetchEpisodeList', [EpisodeController::class, 'fetchEpisodeList'])->middleware(['checkLogin']);
Route::post('updateEpisode/{id}', [EpisodeController::class, 'updateEpisode'])->middleware(['checkLogin']);
Route::post('deleteEpisode/{id}', [EpisodeController::class, 'deleteEpisode'])->middleware(['checkLogin']);

Route::get('contentList/series/source/{id}', [EpisodeController::class, 'episodeList'])->middleware(['checkLogin']);

Route::post('addEpisodeSource', [EpisodeController::class, 'addEpisodeSource'])->middleware(['checkLogin']);
Route::post('fetchEpisodeSourceList/{id}', [EpisodeController::class, 'fetchEpisodeSourceList'])->middleware(['checkLogin']);
Route::post('updateEpisodeSource/{id}', [EpisodeController::class, 'updateEpisodeSource'])->middleware(['checkLogin']);
Route::post('deleteEpisodeSource/{id}', [EpisodeController::class, 'deleteEpisodeSource'])->middleware(['checkLogin']);

Route::post('addEpisodeSubtitle', [EpisodeController::class, 'addEpisodeSubtitle'])->middleware(['checkLogin']);
Route::post('fetchEpisodeSubtitle/{id}', [EpisodeController::class, 'fetchEpisodeSubtitle'])->middleware(['checkLogin']);
Route::post('deleteEpisodeSubtitle/{id}', [EpisodeController::class, 'deleteEpisodeSubtitle'])->middleware(['checkLogin']);

Route::get('user', [UserController::class, 'user']);
Route::post('fetchUserList', [UserController::class, 'fetchUserList'])->middleware(['checkLogin']);
Route::get('userDetail/{id}', [UserController::class, 'userDetail'])->middleware(['checkLogin']);


