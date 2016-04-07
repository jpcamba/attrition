<?php

class CorrelationController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$attrition = $this->rateAttrition();
		
		/*$rawCorrelation['employment'] = $this->corrEmployment($attrition);
		if ($rawCorrelation['employment'] < 0)
			$correlation['employment'] = -$rawCorrelation['employment'];
		else
			$correlation['employment'] = $rawCorrelation['employment'];

		$rawCorrelation['grades'] = $this->corrGrades($attrition);
		if ($rawCorrelation['grades'] < 0)
			$correlation['grades'] = -$rawCorrelation['grades'];
		else
			$correlation['grades'] =-$rawCorrelation['grades'];*/

		$rawCorrelation['stbracket'] = $this->corrStbracket($attrition);
		if ($rawCorrelation['stbracket'] < 0)
			$correlation['stbracket'] = -$rawCorrelation['stbracket'];
		else
			$correlation['stbracket'] = $rawCorrelation['stbracket'];

		$rawCorrelation['region'] = $this->corrRegion($attrition);
		if ($rawCorrelation['region'] < 0)
			$correlation['region'] = -$rawCorrelation['region'];
		else
			$correlation['region'] = $rawCorrelation['region'];

		/*$rawCorrelation['units'] = $this->corrUnits($attrition);
		if ($rawCorrelation['units'] < 0)
			$correlation['units'] = -$rawCorrelation['units'];
		else
			$correlation['units'] = $rawCorrelation['units'];*/

		$rawCorrelation['unemployment'] = $this->corrUnemployment($attrition);
		if ($rawCorrelation['unemployment'] < 0)
			$correlation['unemployment'] = -$rawCorrelation['unemployment'];
		else
			$correlation['unemployment'] = $rawCorrelation['unemployment'];

		$rawCorrelation['highgrades'] = $this->corrHighGrades($attrition);
		if ($rawCorrelation['highgrades'] < 0)
			$correlation['highgrades'] = -$rawCorrelation['highgrades'];
		else
			$correlation['highgrades'] = $rawCorrelation['highgrades'];

		$rawCorrelation['overloading'] = $this->corrOverloading($attrition);
		if ($rawCorrelation['overloading'] < 0)
			$correlation['overloading'] = -$rawCorrelation['overloading'];
		else
			$correlation['overloading'] = $rawCorrelation['overloading'];

		return View::make('correlation.correlation', compact('rawCorrelation', 'correlation'));
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
		$sumx = 0;
		$sumy = 0;
		$sumxy = 0;
		$sumx2 = 0;
		$sumy2 = 0;
		$n = 0;

		foreach ($batches as $batch) {
			$sumx = $sumx + $factor[$batch];
			$sumy = $sumy + $attrition[$batch];
			$sumxy = $sumxy + ($factor[$batch] * $attrition[$batch]);
			$sumx2 = $sumx2 + pow($factor[$batch], 2);
			$sumy2 = $sumy2 + pow($attrition[$batch], 2);
			$n = $n + 1;
		}

		//return $sumxy / sqrt($sumx2 * $sumy2);

		$correlation = (($n * $sumxy) - ($sumx * $sumy)) / sqrt((($n * $sumx2) - pow($sumx, 2)) * (($n * $sumy2) - pow($sumy, 2)));
		return $correlation;
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

	//Unemployment - Unemployed students
	public function corrUnemployment($attrition) {
		$rateUnemployment = [];
		$results = Correlation::getUnemployment();

		foreach ($results as $result) {
			$rateUnemployment[$result->batch] = $result->ratio;
		}

		return round($this->getCorrelation($rateUnemployment, $attrition), 2);
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

	//Grades - High Grades (3.00 and below)
	public function corrHighGrades($attrition) {
		$rateHighGrades = [];
		$results = Correlation::getHighGrades();

		foreach ($results as $result) {
			$rateHighGrades[$result->batch] = $result->ratio;
		}

		return round($this->getCorrelation($rateHighGrades, $attrition), 2);
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

	//Units - Underloaded students
	public function corrUnits($attrition) {
		$rateUnits = [];
		$results = Correlation::getUnits();

		foreach ($results as $result) {
			$rateUnits[$result->batch] = $result->ratio;
		}

		return round($this->getCorrelation($rateUnits, $attrition), 2);
	}

	//Overloading - Overloaded students
	public function corrOverloading($attrition) {
		$rateUnits = [];
		$results = Correlation::getOverloading();

		foreach ($results as $result) {
			$rateUnits[$result->batch] = $result->ratio;
		}

		return round($this->getCorrelation($rateUnits, $attrition), 2);
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
