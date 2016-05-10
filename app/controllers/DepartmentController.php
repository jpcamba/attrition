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
    						$q->whereNotIn('programid', array(62, 66, 38));
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

			//$departmentAveArray[$department->unitname] = $department->ave_students;
			//$departmentAveAttritionArray[$department->unitname] = $department->ave_batch_attrition;
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
		$departmentprograms = $department->programs()->where('degreelevel', 'U')->whereNotIn('programid', array(62, 66, 38))->get();

	    //ave students per year and ave difference
		$programids = $department->programs()->whereNotIn('programid', array(62, 66, 38))->where('degreelevel', 'U')->lists('programid');
        //To get batches of program whithin 2000-2009
        $yearsArray = Studentterm::whereIn('programid', $programids)->where('year', '>', 1999)->where('year', '<', 2014)->groupBy('year')->orderBy('year', 'asc')->lists('year');

	    $yearlyStudentAverage = [];
	    //$yearlySemDifference = [];
		$departmentProgramsAverage = [];
	    foreach($yearsArray as $yearData){
	        $aveStudents = round($department->getYearlyAveStudents($yearData), 2);
	        if($aveStudents > 1){
	            $yearlyStudentAverage[$yearData] = $aveStudents;
	        }
	        //$semDiff = $department->getYearlySemDifference($yearData->year);
	        //$yearlySemDifference[$yearData->year] = $semDiff;
	    }

		foreach($departmentprograms as $departmentprogram){
			$departmentProgramsAverage[$departmentprogram->programtitle] = round($departmentprogram->getAveStudents(), 2);
			//$departmentProgramsAverage[$departmentprogram->programtitle] = round($departmentprogram->ave_students, 2);
		}


		$batchAttrition = $department->getBatchAttrition();
		$programsAttrition = $department->getProgramsAveBatchAttrition();
		$aveAttrition = $department->getAveAttrition();
		$aveShiftRate = $department->getAveShiftRate();
		$aveYearsBeforeDropout = $department->getAveYearsBeforeDropout();
		$aveYearsBeforeShifting = $department->getAveYearsBeforeShifting();
		//$aveAttrition = $department->ave_batch_attrition;
		//$aveShiftRate = $department->ave_batch_shift;

		//$employmentCount = $department->getEmploymentCount();
		$gradeCount = $department->getGradeCount();
		$shiftGradeCount = $department->getShiftGradeCount();
		$stbracketCount = $department->getSTBracketCount();
		//$regionCount = $department->getRegionCount();
		$shiftBracketCount = $department->getShiftSTBracketCount();

	    return View::make('department.department-specific',
	    ['department' => $department,
	     'yearlyStudentAverage' => $yearlyStudentAverage,
	     //'yearlySemDifference' => $yearlySemDifference,
		 'departmentprograms' => $departmentprograms,
		 'departmentProgramsAverage' => $departmentProgramsAverage,
		 'aveAttrition' => $aveAttrition,
		 'batchAttrition' => $batchAttrition,
		 'aveShiftRate' => $aveShiftRate,
		 'aveYearsBeforeDropout' => $aveYearsBeforeDropout,
		 'aveYearsBeforeShifting' => $aveYearsBeforeShifting,
		 'programsAttrition' => $programsAttrition,
		 //'employmentCount' => $employmentCount,
		 'gradeCount' => $gradeCount,
		 'shiftGradeCount' => $shiftGradeCount,
		 'stbracketCount' => $stbracketCount,
		 //'regionCount' => $regionCount,
		 'shiftBracketCount' => $shiftBracketCount
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
