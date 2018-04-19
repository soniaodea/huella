<?php

use Illuminate\Http\Request;
use App\Models\Building;

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

Route::group(['middleware' => 'enableCors'], function () {

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('register', "Auth\RegisterController@registerApi");
    Route::post('login', "Auth\LoginController@loginApi");
    Route::post('logout', 'Auth\LoginController@logout');

    // Building routes
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('buildings', 'ApiController@showAllBuildings');
        Route::get('buildings/{building}', 'ApiController@showBuilding');
        Route::post('buildings', 'ApiController@storeBuilding');
        Route::post('buildings/{building}', 'ApiController@updateBuilding');
        Route::delete('buildings/{building}', 'ApiController@deleteBuilding');
    });

    // Alcances routes
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('alcances/{building}', 'ApiController@showAlcances');
    });
});
