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
});

//Program
Route::resource('program', 'ProgramController');
Route::group(array('prefix' => 'program'), function () {
	Route::get('/', 'ProgramController@index');
	Route::post('/view_program', 'ProgramController@showSpecificProgram');
});

//College
Route::resource('college', 'CollegeController');
Route::group(array('prefix' => 'college'), function () {
	Route::get('/', 'CollegeController@index');
	Route::post('/view_college', 'CollegeController@showSpecificCollege');
});

//Department
Route::resource('department', 'DepartmentController');
Route::group(array('prefix' => 'department'), function () {
	Route::get('/', 'DepartmentController@index');
	Route::post('/view_department', 'DepartmentController@showSpecificDepartment');
});

//Correlation
Route::resource('correlation', 'CorrelationController');
Route::group(array('prefix' => 'correlation'), function() {
	Route::get('/', 'CorrelationController@index');
	Route::post('college', 'CorrelationController@showCollege');
	Route::post('department', 'CorrelationController@showDepartment');
}); 

//Simulation
Route::group(array('prefix' => 'simulation'), function() {
	Route::get('/', 'SimulationController@index');
	Route::get('employment', 'SimulationController@showEmployment');
	Route::post('employment', 'SimulationController@postEmployment');
	Route::get('grades', 'SimulationController@showGrades');
	Route::post('grades', 'SimulationController@postGrades');
	Route::get('region', 'SimulationController@showRegion');
	Route::post('region', 'SimulationController@postRegion');
	Route::get('stbracket', 'SimulationController@showStbracket');
	Route::post('stbracket', 'SimulationController@postStbracket');
	Route::get('units', 'SimulationController@showUnits');
	Route::post('units', 'SimulationController@postUnits');
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
