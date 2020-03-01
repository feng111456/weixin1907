<?php

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

Route::get('/', function () {
    return view('welcome');
});
/**微信路由 */
Route::prefix('wechat')->group(function () {
    Route::any('/index','Wechat\WechatController@index');
    Route::any('/sendTemplate','Wechat\WechatController@sendTemplate');
    Route::any('/authorized','Wechat\WechatController@authorized');
    Route::any('/test','Wechat\WechatController@test');
    Route::any('/mass_send','Wechat\WechatController@massSend');
});
