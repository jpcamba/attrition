<?php

class DepartmentController extends \BaseController {

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


 		//Averaage students per program
 		$departmentAveArray = [];
		$departmentAveAttritionArray = [];
 		foreach($departmentlist as $department){
 			$collStudents = round($department->getAveStudents(), 2);
			$departmentAveArray[$department->unitname] = $collStudents;
			$deptAttrition = $department->getAveAttrition();
			$departmentAveAttritionArray[$department->unitname] = $deptAttrition;
 		}

 		//return page
 		return View::make('department.department',
 		['departmentlist' => $departmentlist,
 		 'departmentAveArray' => $departmentAveArray,
		 'departmentAveAttritionArray' => $departmentAveAttritionArray
 		]);

 	}

	public function showSpecificDepartment(){
	    $departmentIDInput = Input::get('department-dropdown');
	    $department = Department::find($departmentIDInput);
		$departmentprograms = $department->programs()->where('degreelevel', 'U')->whereNotIn('programid', array(62, 66, 38, 22))->get();

	    //ave students per year and ave difference
	    $yearsArray = Year::all();
	    $yearlyStudentAverage = [];
	    //$yearlySemDifference = [];
		$departmentProgramsAverage = [];
	    foreach($yearsArray as $yearData){
	        $aveStudents = round($department->getYearlyAveStudents($yearData->year), 2);
	        if($aveStudents > 1){
	            $yearlyStudentAverage[$yearData->year] = $aveStudents;
	        }
	        //$semDiff = $department->getYearlySemDifference($yearData->year);
	        //$yearlySemDifference[$yearData->year] = $semDiff;
	    }

		foreach($departmentprograms as $departmentprogram){
			$departmentProgramsAverage[$departmentprogram->programtitle] = round($departmentprogram->getAveStudents(), 2);
		}

		$aveAttrition = $department->getAveAttrition();
		$batchAttrition = $department->getBatchAttrition();
		$aveShiftRate = $department->getAveShiftRate();
		$programsAttrition = $department->getProgramsAveBatchAttrition();

	    return View::make('department.department-specific',
	    ['department' => $department,
	     'yearlyStudentAverage' => $yearlyStudentAverage,
	     //'yearlySemDifference' => $yearlySemDifference,
		 'departmentprograms' => $departmentprograms,
		 'departmentProgramsAverage' => $departmentProgramsAverage,
		 'aveAttrition' => $aveAttrition,
		 'batchAttrition' => $batchAttrition,
		 'aveShiftRate' => $aveShiftRate,
		 'programsAttrition' => $programsAttrition
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
