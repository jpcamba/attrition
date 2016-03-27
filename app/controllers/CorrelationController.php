<?php

class CorrelationController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$attrition = $this->rateAttrition();
		$correlation['employment'] = $this->corrEmployment($attrition);
		$correlation['grades'] = $this->corrGrades($attrition);
		$correlation['stbracket'] = $this->corrStbracket($attrition);
		$correlation['region'] = $this->corrRegion($attrition);

		//up manila
		$campus = Campus::where('unitid', 2)->first();
		//$employmentCount = $campus->getEmploymentCount();
		//$gradeCount = $campus->getGradeCount();
		//$stbracketCount = $campus->getSTBracketCount();
		//$regionCount = $campus->getRegionCount();

		/*//employment
		$employmentCount['Employed'] = Unitfactor::where('type', 'Employed')->first()->value;
		$employmentCount['Unemployed'] = Unitfactor::where('type', 'Unemployed')->first()->value;
		//grade
		$gradeCount['Passed'] = Unitfactor::where('type', 'Passed')->first()->value;
		$gradeCount['Failed'] = Unitfactor::where('type', 'Failed')->first()->value;
		//region
		$regionCount['Luzon'] = Unitfactor::where('type', 'Luzon')->first()->value;
		$regionCount['Visayas'] = Unitfactor::where('type', 'Visayas')->first()->value;
		$regionCount['Mindanao'] = Unitfactor::where('type', 'Mindanao')->first()->value;
		//stbracket
		$stbracketCount['A'] = Unitfactor::where('type', 'A')->first()->value;
		$stbracketCount['B'] = Unitfactor::where('type', 'B')->first()->value;
		$stbracketCount['C'] = Unitfactor::where('type', 'C')->first()->value;
		$stbracketCount['D'] = Unitfactor::where('type', 'D')->first()->value;
		$stbracketCount['E1'] = Unitfactor::where('type', 'E1')->first()->value;
		$stbracketCount['E2'] = Unitfactor::where('type', 'E2')->first()->value;*/


		return View::make('correlation.correlation', compact(
			'correlation' 
			//'employmentCount',
			//'gradeCount',
			//'stbracketCount',
			//'regionCount'
		));
	}

	//Total Attrition Rate
	public function rateAttrition() {
		$batches = [200000000, 200100000, 200200000, 200300000, 200400000, 200500000, 200600000, 200700000, 200800000, 200900000];
		$batchAttrition = [];

		foreach ($batches as $batch) {
			$allBatchDropouts = Studentdropout::getBatchDropoutsCount($batch);
			$allBatchStudents = Studentterm::getBatchStudentsCount($batch);

			$batchAttrition[$batch / 100000] = $allBatchDropouts / $allBatchStudents;
		}

		return $batchAttrition;
	}

	//Get Correlation
	public function getCorrelation($factor, $attrition) {
		$batches = [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009];
		$sumxy = 0;
		$sumx2 = 0;
		$sumy2 = 0;

		foreach ($batches as $batch) {
			$sumxy = $sumxy + ($factor[$batch] * $attrition[$batch]);
			$sumx2 = $sumx2 + pow($factor[$batch], 2);
			$sumy2 = $sumy2 + pow($attrition[$batch], 2);
		}

		if ($sumx2 === 0 || $sumy2 === 0)
			return 0;
		else
			return $sumxy / sqrt($sumx2 * $sumy2);
	}

	//Employment - Employed
	public function corrEmployment($attrition) {
		$rateEmployment = [];
		$results = Correlation::getEmployment();

		foreach ($results as $result) {
			$rateEmployment[$result->batch] = $result->ratio;
		}

		return round($this->getCorrelation($rateEmployment, $attrition), 2);
	}

	//Grades - Low Grades (3.00 and below)
	public function corrGrades($attrition) {
		$rateGrades = [];
		$results = Correlation::getGrades();

		foreach ($results as $result) {
			$rateGrades[$result->batch] = $result->ratio;
		}

		return round($this->getCorrelation($rateGrades, $attrition), 2);
	}

	//ST Bracket - Poor Students (D and below)
	public function corrStbracket($attrition) {
		$rateStrbacket = [];
		$results = Correlation::getStbracket();

		foreach ($results as $result) {
			$rateStbracket[$result->batch] = $result->ratio;
		}

		return round($this->getCorrelation($rateStbracket, $attrition), 2);
	}

	//Region - Students who live far (Visayas, Mindanao)
	public function corrRegion($attrition) {
		$rateRegion = [];
		$results = Correlation::getRegion();

		foreach ($results as $result) {
			$rateRegion[$result->batch] = $result->ratio;
		}

		return round($this->getCorrelation($rateRegion, $attrition), 2);
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
