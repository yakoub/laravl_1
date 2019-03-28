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

Route::get('/', 'HomeController');

Route::resources([
  'article' => 'ArticleController',
]);

Route::post('export/start', 'ExportController@start')->name('export.start');
Route::get('export/progress', 'ExportController@progress')->name('export.progress');
Route::get('export/download/{name}', 'ExportController@download')->name('export.download');
