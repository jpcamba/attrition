<?php


class CampusController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$yearlySemDifference = $this->getSemDifference();
		$yearlyStudentAverage = $this->getStudentAverage();
		$aveYearsOfStay = $this->getAverageYears();
		$aveAttrition = $this->getAveAttrition();
		$batchAttrition = $this->getBatchAttrition();

		//return page
		return View::make('campus.campus',
		['yearlyStudentAverage' => $yearlyStudentAverage,
		'yearlySemDifference' => $yearlySemDifference,
		//'studenttermsArray' => $studenttermsArray
		'aveYearsOfStay' => $aveYearsOfStay,
		//'students' => $students
		'aveAttrition' => $aveAttrition,
		'batchAttrition' => $batchAttrition
		]);
	}

	//Get total attrition
	public function getAveAttrition() {
		$sumAttrition = 0;
		$batches = [200000000, 200100000, 200200000, 200300000, 200400000, 200500000, 200600000, 200700000, 200800000, 200900000];
		$batchAttrs = $this->getBatchAttrition();

		foreach ($batches as $batch) {
			$sumAttrition = $sumAttrition + count(Studentdropout::getBatchDropouts($batch));
		}

		$totalStudents = count(DB::table('studentterms')->select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>', 200000000)->where('studentterms.studentid', '<', 201000000)->get());

		$aveAttrition = round(($sumAttrition / $totalStudents) * 100, 2);
		return $aveAttrition;
	}

	//Get batch attrition
	public function getBatchAttrition() {
		$batchAttrition = [];
		$batches = [200000000, 200100000, 200200000, 200300000, 200400000, 200500000, 200600000, 200700000, 200800000, 200900000];

		foreach ($batches as $batch) {
			$batchEnd = $batch + 100000;
			$allBatchDropouts = Studentdropout::getBatchDropouts($batch);
			$allBatchStudents = DB::table('studentterms')->select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>', $batch)->where('studentterms.studentid', '<', $batchEnd)->get();

			$batchAttrition[$batch / 100000] = round((count($allBatchDropouts) / count($allBatchStudents)) * 100, 2);
		}

		return $batchAttrition;
	}

	//Get average number of students per year
	public function getStudentAverage() {
		$yearsArray = Year::where('year','>', 1998)->get();
		//$yearsArray = Year::all();
		$yearlyStudentAverage = [];

		foreach($yearsArray as $yearData){
			$yearlyStudentAverage[$yearData->year] = $yearData->getAveStudents();
		}

		return $yearlyStudentAverage;
	}

	//Get semester difference
	public function getSemDifference() {
		$yearsArray = Year::where('year','>', 1998)->get();
		//$yearsArray = Year::all();
		$yearlySemDifference = [];
		foreach($yearsArray as $yearData){
			$yearlySemDifference[$yearData->year] = $yearData->getSemDifference();
		}

		return $yearlySemDifference;
	}

	//Get average years of stay
	public function getAverageYears() {
		/*get average number of years a student stays in the university
			1. get number of students with studentterms
			2. get number of years of each student by dividing number of terms by 3
			3. get average of step 2 (accdng to a site, sum/count is faster than avg command)
		*/
		$numberOfYearsPerStudent = DB::table('studentterms')->join('programs', 'programs.programid', '=', 'studentterms.programid')->select(DB::raw('COUNT(*)/3 as numYears'))->where('programs.degreelevel', 'U')->whereNotIn('programs.programid', array(62, 66, 38, 22))->groupBy('studentid')->get();
		$numberOfStudents = count($numberOfYearsPerStudent);

		$totalYears = 0;
		foreach($numberOfYearsPerStudent as $key => $val){
			$totalYears = $totalYears + $val->numyears;
		}
		$aveYearsOfStay = round($totalYears/$numberOfStudents, 2);
		return $aveYearsOfStay;
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
