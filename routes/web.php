<?php

use App\Models\Settings;
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

Route::group(['middleware' => 'throttle:100,1'], function () {

    Auth::routes(['register' => false]);

    Route::group(['middleware' => 'auth'], function () {

        Route::post('admin/page', '\App\Http\Controllers\PageController@create');
        Route::put('admin/page/{id}', '\App\Http\Controllers\PageController@update');
        Route::patch('admin/page/weights', '\App\Http\Controllers\PageController@updateWeights');
        Route::delete('admin/page/{id}', '\App\Http\Controllers\PageController@discard');

        Route::post('admin/project', '\App\Http\Controllers\ProjectController@create');
        Route::put('admin/project/{id}', '\App\Http\Controllers\ProjectController@update');
        Route::delete('admin/project/{id}', '\App\Http\Controllers\ProjectController@discard');

        Route::patch('admin/projects/weights', '\App\Http\Controllers\ProjectController@updateWeights');

        Route::post('admin/block', '\App\Http\Controllers\BlockController@create');
        Route::put('admin/blocks', '\App\Http\Controllers\BlockController@updateMultiple');
        Route::delete('admin/block/{id}', '\App\Http\Controllers\BlockController@discard');

        Route::post('admin/section', '\App\Http\Controllers\SectionController@create');
        Route::put('admin/section/{id}', '\App\Http\Controllers\SectionController@update');
        Route::delete('admin/section/{id}', '\App\Http\Controllers\SectionController@discard');
        Route::patch('admin/section/{id}/up', '\App\Http\Controllers\SectionController@moveUp');
        Route::patch('admin/section/{id}/down', '\App\Http\Controllers\SectionController@moveDown');

        Route::get('admin/media', '\App\Http\Controllers\MediaController@showMediaForm');
        Route::post('admin/media', '\App\Http\Controllers\MediaController@uploadMedia');
        Route::put('admin/media/{id}', '\App\Http\Controllers\MediaController@updateMedia');
        Route::delete('admin/media/{id}', '\App\Http\Controllers\MediaController@deleteMedia');
        Route::get('admin/media-data/', '\App\Http\Controllers\MediaController@getMediaData');
        Route::get('admin/media-data/{stringIDs}', '\App\Http\Controllers\MediaController@getMediaData');
        Route::get('admin/media-data/project/{projectID}', '\App\Http\Controllers\MediaController@getProjectMediaData');

        Route::get('admin/settings', '\App\Http\Controllers\SettingsController@showSettingsForm');
        Route::put('admin/settings', '\App\Http\Controllers\SettingsController@updateSettings');

        Route::get('admin/user', '\App\Http\Controllers\UserController@showForm');
        Route::put('admin/user', '\App\Http\Controllers\UserController@update');
    });

    Route::post('contact', '\App\Http\Controllers\WebController@contactUs');
    Route::post('review', '\App\Http\Controllers\WebController@submitReview');

    Route::get('review/approve/{id}', '\App\Http\Controllers\WebController@approveReview');
    Route::get('review/discard/{id}', '\App\Http\Controllers\WebController@discardReview');

    Route::get('project/{slug}', '\App\Http\Controllers\ProjectController@show');
    Route::get('project/{slug}/next', '\App\Http\Controllers\ProjectController@showNext');
    Route::get('project/{slug}/prev', '\App\Http\Controllers\ProjectController@showPrev');

    Route::get('/', '\App\Http\Controllers\PageController@show');
    Route::get('{slug}', '\App\Http\Controllers\PageController@show');
});

