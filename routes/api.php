<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(
    [
        'prefix'=>'/v1',
        'namespace' => 'Api\V1',
        'as' => 'api'
    ], function(){
    
    Route::middleware(['web'])->group(function () {
        Route::get('/products/filter/{min}/{max}','ProductsSearchApiController@search_minmax');
        Route::post('/products/filter','ProductsSearchApiController@search');
        Route::get('/products/MinMax','ProductsSearchApiController@MinMax');
    });    
});

