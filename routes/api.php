<?php

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

Route::group(['middleware' => 'doNotCacheResponse', 'prefix' => 'oauth'], function () {
    Route::post('token', 'Api@oauth');
    Route::get('owner', 'Api@oauthOwner');
});

Route::post('/validate', 'Validation@validate');

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setlocale',
], function () {
    Route::any('{fallbackPlaceholder}', 'Api@api')->where('fallbackPlaceholder', '.*');
});

Route::any('{fallbackPlaceholder}', 'Api@api')->where('fallbackPlaceholder', '.*')->fallback();
