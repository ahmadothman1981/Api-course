<?php

use App\Http\Controllers\Api\AdController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api2\SettingController;
use App\Http\Controllers\Api2\CityController;
use App\Http\Controllers\Api2\DistrictController;
use App\Http\Controllers\Api2\MessagesController;
use App\Http\Controllers\Api2\DomainController;
use App\Http\Controllers\Api2\AuthController;
use App\Http\Controllers\Api2\AdsController;



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
//---------------------------//Auth Module--------------////////////////
Route::controller(AuthController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
    Route::post('logout','logout')->middleware('auth:sanctum');
});

## ---------------------------------- Setting MODULE 
Route::get('/setting',SettingController::class);
## ---------------------------------- City MODULE 
Route::get('/cities',CityController::class);
## ---------------------------------- DISTRICT MODULE 
Route::get('/district/{city_id}',DistrictController::class);
## ---------------------------------- Contact Us MODULE 
Route::post('/messages',MessagesController::class);
## ---------------------------------- Domain Us MODULE 
Route::get('/domain',DomainController::class);
//////////////////////////////////ADS MODULE//////////////////////////
Route::prefix('ads')->controller(AdsController::class)->group(function(){

    Route::get('/','index');
    Route::get('/latest','latest');
    Route::get('/domain/{domain_id}','domain');
    Route::get('/search','search');

    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/create','create');
        Route::post('/update/{Ad_id}','update');
        Route::get('/delete/{ad_id}','delete');
        Route::get('/myAds','myAds');
    });
});

