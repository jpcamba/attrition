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
		foreach($programlist as $program){
			$progStudents = round($program->getAveStudents(), 2);
			$programAveArray[$program->programtitle] = $progStudents;
		}

		//return page
		return View::make('program.program',
		['programlist' => $programlist,
		 'programAveArray' => $programAveArray
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
			$aveStudents = $yearData->getAveProgramStudents($programIDInput);
			if($aveStudents > 1){
				$yearlyStudentAverage[$yearData->year] = $aveStudents;
			}
			$semDiff = $yearData->getProgramSemDifference($programIDInput);
			//if($semDiff > 1){
				$yearlySemDifference[$yearData->year] = $semDiff;
			//}
		}

		return View::make('program.program-specific',
		['program' => $program,
		 'yearlyStudentAverage' => $yearlyStudentAverage,
		 'yearlySemDifference' => $yearlySemDifference
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
