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
Route::get('/', 'CampusController@index');

//Campus
Route::resource('campus', 'CampusController');
Route::group(array('prefix' => 'campus'), function () {
	Route::get('/', 'CampusController@index');
	//Route::post('/view_college', 'CollegeController@showSpecificCollege');
});

//Program
Route::resource('program', 'ProgramController');
Route::group(array('prefix' => 'program'), function () {
	Route::get('/', 'ProgramController@index');
	Route::post('/view_program', 'ProgramController@showSpecificProgram');
});

/*Route::group(array('prefix' => 'campus'), function () {
	Route::get('/', 'HomeController@showCampus');
});*/

//College
Route::resource('college', 'CollegeController');
Route::group(array('prefix' => 'college'), function () {
	Route::get('/', 'CollegeController@index');
	Route::post('/view_college', 'CollegeController@showSpecificCollege');
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
