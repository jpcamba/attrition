<?php


class CampusController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//up manila
		$campus = Campus::where('unitid', 2)->first();
		$yearlySemDifference = $campus->getSemDifference();
		$yearlyStudentAverage = $campus->getStudentAverage();
		//$aveYearsOfStay = $this->getAverageYears();
		//$aveAttrition = $campus->getAveAttrition();
		$aveAttrition = $campus->ave_batch_attrition;
		$batchAttrition = $campus->getBatchAttrition();
		$aveDropouts = $campus->getAveDropouts();
		$batchDropouts = $campus->getBatchDropouts();
		//$aveYearsBeforeDropout = $campus->getAveYearsBeforeDropout();
		$aveYearsBeforeDropout = $campus->years_before_drop;

		//transferred to correlation
		//$employmentCount = $campus->getEmploymentCount();
		//$gradeCount = $campus->getGradeCount();
		//$stbracketCount = $campus->getSTBracketCount();
		//$regionCount = $campus->getRegionCount();

		//return page
		return View::make('campus.campus',
		['yearlyStudentAverage' => $yearlyStudentAverage,
		'yearlySemDifference' => $yearlySemDifference,
		'aveAttrition' => $aveAttrition,
		'batchAttrition' => $batchAttrition,
		'aveDropouts' => $aveDropouts,
		'batchDropouts' => $batchDropouts,
		'aveYearsBeforeDropout' => $aveYearsBeforeDropout
		//'employmentCount' => $employmentCount,
		//'gradeCount' => $gradeCount,
		//'stbracketCount' => $stbracketCount,
		//'regionCount' => $regionCount
		//'studenttermsArray' => $studenttermsArray
		//'aveYearsOfStay' => $aveYearsOfStay,
		//'students' => $students
		]);
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
