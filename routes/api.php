<?php

use App\Http\Controllers\Api\AppActivity;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\Catalog;
use App\Http\Controllers\Api\LikedTracks;
use App\Http\Controllers\Api\Login;
use App\Http\Controllers\Api\Playlist;
use App\Http\Controllers\Api\PurchasedTracks;
use App\Http\Controllers\Api\RefreshAccessToken;
use App\Http\Controllers\Api\Search;
use App\Http\Controllers\api\Streambox;
use App\Http\Controllers\ElasticSearch;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GetAccessToken;

Route::post('login',[Login::class, 'login']);
Route::post('/get_access_token', [GetAccessToken::class, 'getToken']);
Route::post('/refresh_access_token', [RefreshAccessToken::class, 'refreshAccessToken']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/liked_tracks', [LikedTracks::class, 'likedTracks']);
    Route::post('/purchased_tracks', [PurchasedTracks::class, 'index']);
    Route::post('/release', [Catalog::class, 'release']);
    Route::post('/releases', [Catalog::class, 'releases']);
    Route::post('/track', [Catalog::class, 'track']);
    Route::post('/tracks', [Catalog::class, 'tracks']);
    Route::get('/top100/streams', [Catalog::class, 'top100_streams']);
    Route::get('/top100/prime', [Catalog::class, 'top100_prime']);
    Route::get('/top100/crew_picks', [Catalog::class, 'top100_crew_pick']);
    Route::get('/top100/releases', [Catalog::class, 'top100_releases']);
    Route::post('/top100/genre', [Catalog::class, 'top100_genre']);
    Route::post('/weekly_charts', [Catalog::class, 'weekly_chart']);
    Route::post('playlist/all', [Playlist::class, 'index']);
    Route::post('playlist/single', [Playlist::class, 'show']);
    Route::post('playlist/create', [Playlist::class, 'create']);
    Route::post('playlist/update', [Playlist::class, 'update']);
    Route::post('playlist/delete', [Playlist::class, 'delete']);
    Route::post('playlist/add_items', [Playlist::class, 'addTracks']);
    Route::post('playlist/remove_items', [Playlist::class, 'removeTracks']);
    Route::post('search/tracks', [Search::class, 'search_tracks']);
    Route::post('search/releases', [Search::class, 'search_realeses']);
    Route::post('search/artists', [Search::class, 'search_artist']);
    Route::post('search/labels', [Search::class, 'search_label']);
    Route::post('create_cart', [CartController::class, 'create_cart']);
    Route::post('add_to_cart', [CartController::class, 'addToCart']);
    Route::post('add_activity', [AppActivity::class, 'add_activity']);
    Route::post('/logout', [Login::class, 'logout']);
    Route::post('getCharts', [Streambox::class, 'getCharts']);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
