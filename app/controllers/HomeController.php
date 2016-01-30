<?php

class HomeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function showDashboard() {
		return View::make('dashboard');
	}

	public function showCampus() {
		return View::make('campus.campus');
	}

	public function showCollege() {
		return View::make('college.college');
	}

	public function showSpecificCollege() {
		return View::make('college.cmc');
	}

	public function showProgram() {
		return View::make('program.program');
	}

	public function showSpecificProgram() {
		return View::make('program.broadcomm');
	}



	//Dashboard Elements
	public function showElUiElements() {
		return View::make('elements/ui-elements');
	}

	public function showElChart() {
		return View::make('elements/chart');
	}

	public function showElTabPanel() {
		return View::make('elements/tab-panel');
	}

	public function showElTable() {
		return View::make('elements/table');
	}

	public function showElForm() {
		return View::make('elements/form');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
