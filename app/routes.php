<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Main Dashboard
Route::get('/', 'HomeController@showCampus');

//Campus
Route::group(array('prefix' => 'campus'), function () {	
	Route::get('/', 'HomeController@showCampus');
});

//College
Route::group(array('prefix' => 'college'), function () {	
	Route::get('/', 'HomeController@showCollege');
	Route::get('cmc', 'HomeController@showSpecificCollege');
});

//Program
Route::group(array('prefix' => 'program'), function () {
	Route::get('/', 'HomeController@showProgram');
	Route::get('broadcomm', 'HomeController@showSpecificProgram');
});

//Prediction
Route::group(array('prefix' => 'prediction'), function () {
	Route::get('/', 'HomeController@showPrediction');
});

//Simulation
Route::group(array('prefix' => 'simulation'), function () {
	Route::get('employment', 'HomeController@showSimEmployment');
	Route::get('housing', 'HomeController@showSimHousing');
	Route::get('grades', 'HomeController@showSimGrades');
	Route::get('stdiscount', 'HomeController@showSimStdiscount');
	Route::get('units', 'HomeController@showSimUnits');
});

//Elements
Route::group(array('prefix' => 'elements'), function () {
	Route::get('ui-elements', 'HomeController@showElUiElements');
	Route::get('chart', 'HomeController@showElChart');
	Route::get('tab-panel', 'HomeController@showElTabPanel');
	Route::get('table', 'HomeController@showElTable');
	Route::get('form', 'HomeController@showElForm');
	Route::get('empty', 'HomeController@showElEmpty');
});
