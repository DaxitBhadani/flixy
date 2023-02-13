<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\CastController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\EpisodeSubtitleController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\TvCategoryController;
use App\Http\Controllers\TvChannelController;
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

Route::get('/index', [MainController::class, 'index']);


Route::get('language', [LanguageController::class, 'language']);
Route::post('storeLanguage', [LanguageController::class, 'storeLanguage']);
Route::post('fetchLanguageList', [LanguageController::class, 'fetchLanguageList']);
Route::post('updateLanguage/{id}', [LanguageController::class, 'updateLanguage']);
Route::post('deleteLanguage/{id}', [LanguageController::class, 'deleteLanguage']);


Route::get('genre', [GenreController::class, 'genre']);
Route::post('storeGenre', [GenreController::class, 'storeGenre']);
Route::post('fetchGenreList', [GenreController::class, 'fetchGenreList']);
Route::post('updateGenre/{id}', [GenreController::class, 'updateGenre']);
Route::post('deleteGenre/{id}', [GenreController::class, 'deleteGenre']);


Route::get('actors', [ActorController::class, 'actors']);
Route::post('storeActor', [ActorController::class, 'storeActor']);
Route::post('fetchActorList', [ActorController::class, 'fetchActorList']);
Route::post('updateActor/{id}', [ActorController::class, 'updateActor']);
Route::post('deleteActor/{id}', [ActorController::class, 'deleteActor']);


Route::get('tvCategory', [TvCategoryController::class, 'tvCategory']);
Route::post('storeTvCategory', [TvCategoryController::class, 'storeTvCategory']);
Route::post('fetchTvCategoryList', [TvCategoryController::class, 'fetchTvCategoryList']);
Route::post('updateTvCategory/{id}', [TvCategoryController::class, 'updateTvCategory']);
Route::post('deleteTvCategory/{id}', [TvCategoryController::class, 'deleteTvCategory']);


Route::get('tvChannel', [TvChannelController::class, 'tvChannel']);
Route::post('storeTvChannel', [TvChannelController::class, 'storeTvChannel']);
Route::post('fetchTvChannelList', [TvChannelController::class, 'fetchTvChannelList']);
Route::post('updateTvChannel/{id}', [TvChannelController::class, 'updateTvChannel']);
Route::post('deleteTvChannel/{id}', [TvChannelController::class, 'deleteTvChannel']);

// Route::get('test', [TvChannelController::class, 'test']);

Route::get('contentList', [ContentController::class, 'contentList']);
Route::post('storeNewContent', [ContentController::class, 'storeNewContent']);
Route::post('fetchContentList', [ContentController::class, 'fetchContentList']);
Route::post('updateContent/{id}', [ContentController::class, 'updateContent']);
Route::post('deleteContent/{id}', [ContentController::class, 'deleteContent']);

Route::post('fetchContentSeries', [ContentController::class, 'fetchContentSeries']);

Route::get('contentList/{id}', [SourceController::class, 'contentListEdit']);
Route::post('addSource', [SourceController::class, 'storeNewSource']);
Route::post('contentList/sourceList', [SourceController::class, 'sourceList']);
Route::post('updateSource/{id}', [SourceController::class, 'updateSource']);
Route::post('deleteSource/{id}', [SourceController::class, 'deleteSource']);


Route::post('storeNewCast', [SourceController::class, 'storeNewCast']);
Route::post('contentList/castList', [SourceController::class, 'castList']);
Route::post('updateCast/{id}', [SourceController::class, 'updateCast']);
Route::post('deleteCast/{id}', [SourceController::class, 'deleteCast']);

Route::post('storeSubtitle', [SourceController::class, 'storeSubtitle']);
Route::post('contentList/SubtitleList', [SourceController::class, 'SubtitleList']);
Route::post('deleteSubtitle/{id}', [SourceController::class, 'deleteSubtitle']);


Route::get('contentList/series/{id}', [SeriesController::class, 'seriesList']);
Route::post('addSeason', [SeriesController::class, 'addSeason']);
Route::post('updateSeason/{id}', [SeriesController::class, 'updateSeason']);
Route::post('deleteSeason/{id}', [SeriesController::class, 'deleteSeason']);

Route::post('addEpisode', [EpisodeController::class, 'addEpisode']);
Route::post('fetchEpisodeList', [EpisodeController::class, 'fetchEpisodeList']);
Route::post('updateEpisode/{id}', [EpisodeController::class, 'updateEpisode']);
Route::post('deleteEpisode/{id}', [EpisodeController::class, 'deleteEpisode']);

Route::get('contentList/series/source/{id}', [EpisodeController::class, 'episodeList']);

Route::post('addEpisodeSource', [EpisodeController::class, 'addEpisodeSource']);
Route::post('fetchEpisodeSourceList/{id}', [EpisodeController::class, 'fetchEpisodeSourceList']);
Route::post('updateEpisodeSource/{id}', [EpisodeController::class, 'updateEpisodeSource']);
Route::post('deleteEpisodeSource/{id}', [EpisodeController::class, 'deleteEpisodeSource']);

Route::post('addEpisodeSubtitle', [EpisodeController::class, 'addEpisodeSubtitle']);
Route::post('fetchEpisodeSubtitle/{id}', [EpisodeController::class, 'fetchEpisodeSubtitle']);
Route::post('deleteEpisodeSubtitle/{id}', [EpisodeController::class, 'deleteEpisodeSubtitle']);