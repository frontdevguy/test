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

Route::post('/status/text', 'StatusController@addText')->name('add-text-status');
Route::post('/status/video', 'StatusController@addVideo')->name('add-video-status');
Route::post('/comment/text', 'CommentController@addComment')->name('add-status-comment');


Route::put('/status/text', 'StatusController@updateText')->name('update-text-status');
Route::put('/comment/text', 'CommentController@updateComment')->name('update-status-comment');


Route::delete('/status/text', 'StatusController@removeText')->name('remove-text-status');
Route::delete('/status/video', 'StatusController@removeVideo')->name('remove-video-status');
Route::delete('/comment/text', 'CommentController@removeComment')->name('remove-status-comment');

