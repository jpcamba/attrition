<?php

class CollegeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	 public function index()
 	{
		$departmentlist = Department::whereHas('programs', function($q){
							$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->get();

		$collegelist = [];
		foreach($departmentlist as $department){
			array_push($collegelist, $department->college);
		}
		$collegelist = array_unique($collegelist);

 		//Averaage students per program
 		$collegeAveArray = [];
 		foreach($collegelist as $college){
 			$collStudents = round($college->getAveStudents(), 2);
			$collegeAveArray[$college->unitname] = $collStudents;
			$collAttrition = $college->getAveAttrition();
			$collegeAveAttritionArray[$college->unitname] = $collAttrition;
 		}

 		//return page
 		return View::make('college.college',
 		['collegelist' => $collegelist,
 		 'collegeAveArray' => $collegeAveArray,
		 'collegeAveAttritionArray' => $collegeAveAttritionArray
 		]);

 	}

	public function showSpecificCollege(){
	    $collegeIDInput = Input::get('college-dropdown');
	    $college = College::find($collegeIDInput);
		$collegedepartments = $college->departments()->whereHas('programs', function($q){
							$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->get();

	    //ave students per year and ave difference
	    $yearsArray = Year::all();
	    $yearlyStudentAverage = [];
	    //$yearlySemDifference = [];
		$collegeDepartmentsAverage = [];
	    foreach($yearsArray as $yearData){
	        $aveStudents =  round($college->getYearlyAveStudents($yearData->year), 2);
	        if($aveStudents > 1){
	            $yearlyStudentAverage[$yearData->year] = $aveStudents;
	        }
	        //$semDiff = $college->getYearlySemDifference($yearData->year);
	        //$yearlySemDifference[$yearData->year] = $semDiff;
	    }

		foreach($collegedepartments as $collegedepartment){
			$collegeDepartmentsAverage[$collegedepartment->unitname] = round($collegedepartment->getAveStudents(), 2);
		}

		$aveAttrition = $college->getAveAttrition();
		$batchAttrition = $college->getBatchAttrition();
		$aveShiftRate = $college->getAveShiftRate();
		$departmentsAttrition = $college->getDepartmentsAveBatchAttrition();

	    return View::make('college.college-specific',
	    ['college' => $college,
	     'yearlyStudentAverage' => $yearlyStudentAverage,
	     //'yearlySemDifference' => $yearlySemDifference,
		 'collegedepartments' => $collegedepartments,
		 'collegeDepartmentsAverage' => $collegeDepartmentsAverage,
		 'aveAttrition' => $aveAttrition,
		 'batchAttrition' => $batchAttrition,
		 'aveShiftRate' => $aveShiftRate,
		 'departmentsAttrition' => $departmentsAttrition
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
