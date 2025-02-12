<?php

use Illuminate\Support\Facades\Route;

// Used by HAProxy to check if app is running.
Route::get('healthcheck', '\App\Http\Controllers\PageController@show');
