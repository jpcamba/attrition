<?php


class ProgramController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $programlist = Program::where('programs.degreelevel', 'U')->whereNotIn('programs.programid', array(62, 66, 38))->get();

		//Averaage students per program
		$programAveArray = [];
		$programBatchAttrition = [];
		foreach($programlist as $program){
			$progStudents = round($program->getAveStudents(), 2);
			$programAveArray[$program->programtitle] = $progStudents;
			$programBatchAttrition[$program->programtitle] = $program->getAveAttrition();
		}

		//return page
		return View::make('program.program',
		['programlist' => $programlist,
		 'programAveArray' => $programAveArray,
		 'programBatchAttrition' => $programBatchAttrition
		]);

	}

	public function showSpecificProgram(){
		$programIDInput = Input::get('program-dropdown');
		$program = Program::find($programIDInput);

		//ave students per year and ave difference
		$yearsArray = Studentterm::where('programid', $program->programid)->where('year', '>', 1999)->where('year', '<', 2014)->groupBy('year')->orderBy('year', 'asc')->lists('year');
		$yearlyStudentAverage = [];
		$yearlySemDifference = [];
		foreach($yearsArray as $yearData){
			$aveStudents = $program->getYearlyAveStudents($yearData);
			if($aveStudents > 1){
				$yearlyStudentAverage[$yearData] = $aveStudents;
			}
		}

		$aveYearsOfStay = $program->getAveYearsOfStay();
		$aveYearsBeforeDropout = $program->getAveYearsBeforeDropout();
		$aveYearsBeforeShifting = $program->getAveYearsBeforeShifting();
		$aveAttrition = $program->getAveAttrition();
		$aveShiftRate = $program->getAveShiftRate();

		$batchAttrition = $program->getBatchAttrition();
		$batchShiftRate = $program->getBatchShiftRate();
		$division = $program->getDivision();
		$numYears = $program->getNumYears();

		$gradeCount = $program->getGradeCount();
		$shiftGradeCount = $program->getShiftGradeCount();
		$stbracketCount = $program->getSTBracketCount();
		$shiftBracketCount = $program->getShiftSTBracketCount();


		return View::make('program.program-specific',
		['program' => $program,
		 'aveYearsOfStay' => $aveYearsOfStay,
		 'yearlyStudentAverage' => $yearlyStudentAverage,
		 'aveYearsBeforeShifting' => $aveYearsBeforeShifting,
		 'aveYearsBeforeDropout' => $aveYearsBeforeDropout,
		 'aveAttrition' => $aveAttrition,
		 'batchAttrition' => $batchAttrition,
		 'aveShiftRate' => $aveShiftRate,
		 'batchShiftRate' => $batchShiftRate,
		 'division' => $division,
		 'numYears' => $numYears,
		 'gradeCount' => $gradeCount,
		 'shiftGradeCount' => $shiftGradeCount,
		 'stbracketCount' => $stbracketCount,
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
