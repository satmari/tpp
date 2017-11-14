<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', 'WelcomeController@index');

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// C3 table
Route::get('c3', 'C3_Controller@index');
Route::get('add_new_c3', 'C3_Controller@add_new_c3');
Route::post('c3_insert', 'C3_Controller@c3_insert');
Route::get('c3/{id}', 'C3_Controller@edit_c3');
Route::post('c3_update/{id}', 'C3_Controller@update');

// C5 table
Route::get('c5', 'C5_Controller@index');
Route::get('add_new_c5', 'C5_Controller@add_new_c5');
Route::post('c5_insert', 'C5_Controller@c5_insert');
Route::get('c5/{id}', 'C5_Controller@edit_c5');
Route::post('c5_update/{id}', 'C5_Controller@update');

// Po table
Route::get('po', 'Po_Controller@index');
Route::get('add_new_po', 'Po_Controller@add_new_po');
Route::post('po_insert', 'Po_Controller@po_insert');
Route::get('po/{id}', 'Po_Controller@edit_po');
Route::post('po_update/{id}', 'Po_Controller@update');


// Marker

Route::get('marker_add', 'Marker_Controller@index');
Route::post('marker_insert', 'Marker_Controller@marker_insert');

Route::get('show_po', 'Marker_Controller@show_po');
Route::get('show_markers_by_po/{po}', 'Marker_Controller@show_markers_by_po');
Route::get('show_marker_details/{marker}', 'Marker_Controller@show_marker_details');