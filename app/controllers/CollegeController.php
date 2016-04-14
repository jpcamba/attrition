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
			$unitname = substr_replace($college->unitname, "\n", 11, 0);
 			//$collStudents = round($college->getAveStudents(), 2);
			//$collegeAveArray[$unitname] = $collStudents;
			//$collAttrition = $college->getAveAttrition();
			//$collegeAveAttritionArray[$college->unitname] = $collAttrition;

			$collegeAveArray[$unitname] = $college->ave_students;
			$collegeAveAttritionArray[$unitname] = $college->ave_batch_attrition;
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
		$programids = $college->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        //To get batches of program whithin 2000-2009
        $yearsArray = Studentterm::whereIn('programid', $programids)->where('year', '>', 1999)->where('year', '<', 2014)->groupBy('year')->orderBy('year', 'asc')->lists('year');

	    $yearlyStudentAverage = [];
	    //$yearlySemDifference = [];
		$collegeDepartmentsAverage = [];
	    foreach($yearsArray as $yearData){
	        $aveStudents =  round($college->getYearlyAveStudents($yearData), 2);
	        if($aveStudents > 1){
	            $yearlyStudentAverage[$yearData] = $aveStudents;
	        }
	        //$semDiff = $college->getYearlySemDifference($yearData->year);
	        //$yearlySemDifference[$yearData->year] = $semDiff;
	    }

		foreach($collegedepartments as $collegedepartment){
			//$collegeDepartmentsAverage[$collegedepartment->unitname] = round($collegedepartment->getAveStudents(), 2);
			$collegeDepartmentsAverage[$collegedepartment->unitname] = round($collegedepartment->ave_students, 2);
		}

		//$aveAttrition = $college->getAveAttrition();
		//$aveShiftRate = $college->getAveShiftRate();
		$aveYearsBeforeDropout = $college->getAveYearsBeforeDropout();
		$aveYearsBeforeShifting = $college->getAveYearsBeforeShifting();
		$aveAttrition = $college->ave_batch_attrition;
		$aveShiftRate = $college->ave_batch_shift;
		$batchAttrition = $college->getBatchAttrition();
		$departmentsAttrition = $college->getDepartmentsAveBatchAttrition();

		//$employmentCount = $college->getEmploymentCount();
		$gradeCount = $college->getGradeCount();
		$shiftGradeCount = $college->getShiftGradeCount();
		$stbracketCount = $college->getSTBracketCount();
		//$regionCount = $college->getRegionCount();
		$shiftBracketCount = $college->getShiftSTBracketCount();

	    return View::make('college.college-specific',
	    ['college' => $college,
	     'yearlyStudentAverage' => $yearlyStudentAverage,
	     //'yearlySemDifference' => $yearlySemDifference,
		 'collegedepartments' => $collegedepartments,
		 'collegeDepartmentsAverage' => $collegeDepartmentsAverage,
		 'aveAttrition' => $aveAttrition,
		 'batchAttrition' => $batchAttrition,
		 'aveShiftRate' => $aveShiftRate,
		 'aveYearsBeforeDropout' => $aveYearsBeforeDropout,
		 'aveYearsBeforeShifting' => $aveYearsBeforeShifting,
		 'departmentsAttrition' => $departmentsAttrition,
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
