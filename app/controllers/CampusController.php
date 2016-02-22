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
		$yearsArray = Year::where('year','>', 1998)->get();
		//$yearsArray = Year::all();
		$yearlyStudentAverage = [];
		$yearlySemDifference = [];
		foreach($yearsArray as $yearData){
			$yearlyStudentAverage[$yearData->year] = $yearData->getAveStudents();
			$yearlySemDifference[$yearData->year] = $yearData->getSemDifference();
		}

		/*get average number of years a student stays in the university
			1. get number of students with studentterms
			2. get number of years of each student by dividing number of terms by 3
			3. get average of step 2 (accdng to a site, sum/count is faster than avg command)
		*/
		$numberOfYearsPerStudent = DB::table('studentterms')->join('programs', 'programs.programid', '=', 'studentterms.programid')->select(DB::raw('COUNT(*)/3 as numYears'))->whereIn('programs.degree', array('DM', 'BS', 'BA'))->where('programs.programid', '!=', 38)->groupBy('studentid')->get();
		$numberOfStudents = count($numberOfYearsPerStudent);
		$totalYears = 0;
		foreach($numberOfYearsPerStudent as $key => $val){
			$totalYears = $totalYears + $val->numyears;
		}
		$aveYearsOfStay = round($totalYears/$numberOfStudents, 2);

		//return page
		return View::make('campus.campus',
		['yearlyStudentAverage' => $yearlyStudentAverage,
		'yearlySemDifference' => $yearlySemDifference,
		//'studenttermsArray' => $studenttermsArray
		'aveYearsOfStay' => $aveYearsOfStay
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
