<?php


class CampusController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//get data regarding year (Average number of students per year, Sem difference per year)
		$yearsArray = Year::all();
		$yearlyStudentAverage = [];
		$yearlySemDifference = [];
		foreach($yearsArray as $yearData){
			$yearlyStudentAverage[$yearData->year] = $yearData->getAveStudents();
			$yearlySemDifference[$yearData->year] = $yearData->getSemDifference();
		}

		//get average number of years a student stays in the university
		//$students = Student::all(); //ERROR :(
		//$aveYearsOfStay = $students->avg($this->getYearsinUniv());


		/*$studentsRaw = DB::table('students')->get();
		$numberOfStudents =  count($studentsRaw);
		$numOfYears = 0;
		foreach($studentsRaw as $student){
			$studentRecord = Student::where('studentid', $student->studentid)->first();
			$numOfYears = $numOfYears + $studentRecord->getYearsinUniv();
		}
		$aveYearsOfStay = $numOfYears/$numberOfStudents;*/

		/*$students = Student::all();
		$numberOfStudents =  count($students);
		$numOfYears = 0;
		foreach($students as $student){
			$numOfYears = $numOfYears + $student->getYearsinUniv();
		}
		$aveYearsOfStay = $numOfYears/$numberOfStudents;*/


		//return page
		return View::make('campus.campus',
		['yearlyStudentAverage' => $yearlyStudentAverage,
		'yearlySemDifference' => $yearlySemDifference,
		//'aveYearsOfStay' => $aveYearsOfStay
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
