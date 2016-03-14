<?php


class ProgramController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $programlist = Program::where('programs.degreelevel', 'U')->whereNotIn('programs.programid', array(62, 66, 38, 22))->get();

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
		$yearsArray = Year::all();
		$yearlyStudentAverage = [];
		$yearlySemDifference = [];
		foreach($yearsArray as $yearData){
			$aveStudents = $program->getYearlyAveStudents($yearData->year);
			if($aveStudents > 1){
				$yearlyStudentAverage[$yearData->year] = $aveStudents;
			}
			$semDiff = $program->getYearlySemDifference($yearData->year);
			$yearlySemDifference[$yearData->year] = $semDiff;
		}

		$aveYearsOfStay = $program->getAveYearsOfStay();
		$aveYearsBeforeDropout = $program->getAveYearsBeforeDropout();
		$aveYearsBeforeShifting = $program->getAveYearsBeforeShifting();
		$aveAttrition = $program->getAveAttrition();
		$batchAttrition = $program->getBatchAttrition();
		$aveShiftRate = $program->getAveShiftRate();
		$batchShiftRate = $program->getBatchShiftRate();
		$division = $program->getDivision();


		return View::make('program.program-specific',
		['program' => $program,
		 'aveYearsOfStay' => $aveYearsOfStay,
		 'yearlyStudentAverage' => $yearlyStudentAverage,
		 'yearlySemDifference' => $yearlySemDifference,
		 'aveYearsBeforeShifting' => $aveYearsBeforeShifting,
		 'aveYearsBeforeDropout' => $aveYearsBeforeDropout,
		 'aveAttrition' => $aveAttrition,
		 'batchAttrition' => $batchAttrition,
		 'aveShiftRate' => $aveShiftRate,
		 'batchShiftRate' => $batchShiftRate,
		 'division' => $division
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
