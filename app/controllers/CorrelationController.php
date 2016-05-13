<?php

class CorrelationController extends \BaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$correlation = []; 
		$rawCorrelation = [];

		//Factors dropdown + names
		$factors = Factor::select('factorid', 'factorname')->get();
		$factorNames = [];
		foreach ($factors as $factor) {
			$factorNames[$factor->factorid] = $factor->factorname;
		}

		//Programs dropdown + names
		$programs  = Program::select('programtitle', 'programid')->where('degreelevel', 'U')->whereNotIn('programid', array(62, 66, 38, 22))->get();
		$programNames = [];
		foreach ($programs as $program) {
			$programNames[$program->programid] = $program->programtitle;
		}

		//Departments dropdown
		$departments = Department::whereHas('programs', function($q){
    						$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->get();
		$departmentNames = [];
		foreach ($departments as $department) {
			$departmentNames[$department->unitid] = $department->unitname;
		}

		//Colleges dropdown
		$colleges = [];
		$collegeNames = [];
		foreach($departments as $department){
			$college = $department->college;
			array_push($colleges, $college);
			$collegeNames[$college->unitid] = $college->unitname;
		}
		$colleges = array_unique($colleges);

		//Campus Level
		$level = 'campus';
		$id = -1;
		$rawCorrelation[$level][$id][1] = $this->corrEmployment($level);
		if ($rawCorrelation[$level][$id][1] < 0)
			$correlation[$level][$id][1] = -$rawCorrelation[$level][$id][1];
		else
			$correlation[$level][$id][1] = $rawCorrelation[$level][$id][1];

		$rawCorrelation[$level][$id][2] = $this->corrGrades($level);
		if ($rawCorrelation[$level][$id][2] < 0)
			$correlation[$level][$id][2] = -$rawCorrelation[$level][$id][2];
		else
			$correlation[$level][$id][2] = $rawCorrelation[$level][$id][2];

		$rawCorrelation[$level][$id][3] = $this->corrStbracket($level);
		if ($rawCorrelation[$level][$id][3] < 0)
			$correlation[$level][$id][3] = -$rawCorrelation[$level][$id][3];
		else
			$correlation[$level][$id][3] = $rawCorrelation[$level][$id][3];

		$rawCorrelation[$level][$id][4] = $this->corrRegion($level);
		if ($rawCorrelation[$level][$id][4] < 0)
			$correlation[$level][$id][4] = -$rawCorrelation[$level][$id][4];
		else
			$correlation[$level][$id][4] = $rawCorrelation[$level][$id][4];

		$rawCorrelation[$level][$id][6] = $this->corrUnits($level);
		if ($rawCorrelation[$level][$id][6] < 0)
			$correlation[$level][$id][6] = -$rawCorrelation[$level][$id][6];
		else
			$correlation[$level][$id][6] = $rawCorrelation[$level][$id][6];

		$rawCorrelation[$level][$id][8] = $this->corrUnemployment($level);
		if ($rawCorrelation[$level][$id][8] < 0)
			$correlation[$level][$id][8] = -$rawCorrelation[$level][$id][8];
		else
			$correlation[$level][$id][8] = $rawCorrelation[$level][$id][8];

		$rawCorrelation[$level][$id][7] = $this->corrHighGrades($level);
		if ($rawCorrelation[$level][$id][7] < 0)
			$correlation[$level][$id][7] = -$rawCorrelation[$level][$id][7];
		else
			$correlation[$level][$id][7] = $rawCorrelation[$level][$id][7];

		$rawCorrelation[$level][$id][9] = $this->corrOverloading($level);
		if ($rawCorrelation[$level][$id][9] < 0)
			$correlation[$level][$id][9] = -$rawCorrelation[$level][$id][9];
		else
			$correlation[$level][$id][9] = $rawCorrelation[$level][$id][9];

		//College Level
		$level = 'college';
		foreach ($colleges as $college) {
			$id = $college->unitid;
			$rawCorrelation[$level][$id][1] = $this->corrEmployment($level, $id);
			if ($rawCorrelation[$level][$id][1] < 0)
				$correlation[$level][$id][1] = -$rawCorrelation[$level][$id][1];
			else
				$correlation[$level][$id][1] = $rawCorrelation[$level][$id][1];

			$rawCorrelation[$level][$id][2] = $this->corrGrades($level, $id);
			if ($rawCorrelation[$level][$id][2] < 0)
				$correlation[$level][$id][2] = -$rawCorrelation[$level][$id][2];
			else
				$correlation[$level][$id][2] = $rawCorrelation[$level][$id][2];

			$rawCorrelation[$level][$id][3] = $this->corrStbracket($level, $id);
			if ($rawCorrelation[$level][$id][3] < 0)
				$correlation[$level][$id][3] = -$rawCorrelation[$level][$id][3];
			else
				$correlation[$level][$id][3] = $rawCorrelation[$level][$id][3];

			$rawCorrelation[$level][$id][4] = $this->corrRegion($level, $id);
			if ($rawCorrelation[$level][$id][4] < 0)
				$correlation[$level][$id][4] = -$rawCorrelation[$level][$id][4];
			else
				$correlation[$level][$id][4] = $rawCorrelation[$level][$id][4];

			$rawCorrelation[$level][$id][6] = $this->corrUnits($level, $id);
			if ($rawCorrelation[$level][$id][6] < 0)
				$correlation[$level][$id][6] = -$rawCorrelation[$level][$id][6];
			else
				$correlation[$level][$id][6] = $rawCorrelation[$level][$id][6];

			$rawCorrelation[$level][$id][8] = $this->corrUnemployment($level, $id);
			if ($rawCorrelation[$level][$id][8] < 0)
				$correlation[$level][$id][8] = -$rawCorrelation[$level][$id][8];
			else
				$correlation[$level][$id][8] = $rawCorrelation[$level][$id][8];

			$rawCorrelation[$level][$id][7] = $this->corrHighGrades($level, $id);
			if ($rawCorrelation[$level][$id][7] < 0)
				$correlation[$level][$id][7] = -$rawCorrelation[$level][$id][7];
			else
				$correlation[$level][$id][7] = $rawCorrelation[$level][$id][7];

			$rawCorrelation[$level][$id][9] = $this->corrOverloading($level, $id);
			if ($rawCorrelation[$level][$id][9] < 0)
				$correlation[$level][$id][9] = -$rawCorrelation[$level][$id][9];
			else
				$correlation[$level][$id][9] = $rawCorrelation[$level][$id][9];
		}

		//Department Level
		$level = 'department';
		foreach ($departments as $department) {
			$id = $department->unitid;
			$rawCorrelation[$level][$id][1] = $this->corrEmployment($level, $id);
			if ($rawCorrelation[$level][$id][1] < 0)
				$correlation[$level][$id][1] = -$rawCorrelation[$level][$id][1];
			else
				$correlation[$level][$id][1] = $rawCorrelation[$level][$id][1];

			$rawCorrelation[$level][$id][2] = $this->corrGrades($level, $id);
			if ($rawCorrelation[$level][$id][2] < 0)
				$correlation[$level][$id][2] = -$rawCorrelation[$level][$id][2];
			else
				$correlation[$level][$id][2] = $rawCorrelation[$level][$id][2];

			$rawCorrelation[$level][$id][3] = $this->corrStbracket($level, $id);
			if ($rawCorrelation[$level][$id][3] < 0)
				$correlation[$level][$id][3] = -$rawCorrelation[$level][$id][3];
			else
				$correlation[$level][$id][3] = $rawCorrelation[$level][$id][3];

			$rawCorrelation[$level][$id][4] = $this->corrRegion($level, $id);
			if ($rawCorrelation[$level][$id][4] < 0)
				$correlation[$level][$id][4] = -$rawCorrelation[$level][$id][4];
			else
				$correlation[$level][$id][4] = $rawCorrelation[$level][$id][4];

			$rawCorrelation[$level][$id][6] = $this->corrUnits($level, $id);
			if ($rawCorrelation[$level][$id][6] < 0)
				$correlation[$level][$id][6] = -$rawCorrelation[$level][$id][6];
			else
				$correlation[$level][$id][6] = $rawCorrelation[$level][$id][6];

			$rawCorrelation[$level][$id][8] = $this->corrUnemployment($level, $id);
			if ($rawCorrelation[$level][$id][8] < 0)
				$correlation[$level][$id][8] = -$rawCorrelation[$level][$id][8];
			else
				$correlation[$level][$id][8] = $rawCorrelation[$level][$id][8];

			$rawCorrelation[$level][$id][7] = $this->corrHighGrades($level, $id);
			if ($rawCorrelation[$level][$id][7] < 0)
				$correlation[$level][$id][7] = -$rawCorrelation[$level][$id][7];
			else
				$correlation[$level][$id][7] = $rawCorrelation[$level][$id][7];

			$rawCorrelation[$level][$id][9] = $this->corrOverloading($level, $id);
			if ($rawCorrelation[$level][$id][9] < 0)
				$correlation[$level][$id][9] = -$rawCorrelation[$level][$id][9];
			else
				$correlation[$level][$id][9] = $rawCorrelation[$level][$id][9];
		}

		//Program Level
		$level = 'program';
		foreach ($programs as $program) {
			$id = $program->programid;
			$rawCorrelation[$level][$id][1] = $this->corrEmployment($level, $id);
			if ($rawCorrelation[$level][$id][1] < 0)
				$correlation[$level][$id][1] = -$rawCorrelation[$level][$id][1];
			else
				$correlation[$level][$id][1] = $rawCorrelation[$level][$id][1];

			$rawCorrelation[$level][$id][2] = $this->corrGrades($level, $id);
			if ($rawCorrelation[$level][$id][2] < 0)
				$correlation[$level][$id][2] = -$rawCorrelation[$level][$id][2];
			else
				$correlation[$level][$id][2] = $rawCorrelation[$level][$id][2];

			$rawCorrelation[$level][$id][3] = $this->corrStbracket($level, $id);
			if ($rawCorrelation[$level][$id][3] < 0)
				$correlation[$level][$id][3] = -$rawCorrelation[$level][$id][3];
			else
				$correlation[$level][$id][3] = $rawCorrelation[$level][$id][3];

			$rawCorrelation[$level][$id][4] = $this->corrRegion($level, $id);
			if ($rawCorrelation[$level][$id][4] < 0)
				$correlation[$level][$id][4] = -$rawCorrelation[$level][$id][4];
			else
				$correlation[$level][$id][4] = $rawCorrelation[$level][$id][4];

			$rawCorrelation[$level][$id][6] = $this->corrUnits($level, $id);
			if ($rawCorrelation[$level][$id][6] < 0)
				$correlation[$level][$id][6] = -$rawCorrelation[$level][$id][6];
			else
				$correlation[$level][$id][6] = $rawCorrelation[$level][$id][6];

			$rawCorrelation[$level][$id][8] = $this->corrUnemployment($level, $id);
			if ($rawCorrelation[$level][$id][8] < 0)
				$correlation[$level][$id][8] = -$rawCorrelation[$level][$id][8];
			else
				$correlation[$level][$id][8] = $rawCorrelation[$level][$id][8];

			$rawCorrelation[$level][$id][7] = $this->corrHighGrades($level, $id);
			if ($rawCorrelation[$level][$id][7] < 0)
				$correlation[$level][$id][7] = -$rawCorrelation[$level][$id][7];
			else
				$correlation[$level][$id][7] = $rawCorrelation[$level][$id][7];

			$rawCorrelation[$level][$id][9] = $this->corrOverloading($level, $id);
			if ($rawCorrelation[$level][$id][9] < 0)
				$correlation[$level][$id][9] = -$rawCorrelation[$level][$id][9];
			else
				$correlation[$level][$id][9] = $rawCorrelation[$level][$id][9];
		}

		return View::make('correlation.correlation', compact('rawCorrelation', 'correlation', 'programs', 'departments', 'colleges', 'factors', 'factorNames', 'programNames', 'departmentNames', 'collegeNames'));
	}

	//Get Correlation
	public function getCorrelation($factor, $attrition, $batches) {
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

		$num = ($n * $sumxy) - ($sumx * $sumy);
		$den = sqrt((($n * $sumx2) - pow($sumx, 2)) * (($n * $sumy2) - pow($sumy, 2)));

		if ($den > 0)
			return $num / $den;
		else
			0;
	}

	//Employment - Employed
	public function corrEmployment($level, $levelid = null) {
		$rateEmployment = [];
		$attrition = [];
		$batches = [];
		$results = Correlation::getEmployment($level, $levelid);

		foreach ($results as $result) {
			array_push($batches, $result->batch);
			$rateEmployment[$result->batch] = $result->ratio;
			$attrition[$result->batch] = $result->dropouts;
		}

		return round($this->getCorrelation($rateEmployment, $attrition, $batches), 2);
	}

	//Unemployment - Unemployed students
	public function corrUnemployment($level, $levelid = null) {
		$rateUnemployment = [];
		$attrition = [];
		$batches = [];
		$results = Correlation::getUnemployment($level, $levelid);

		foreach ($results as $result) {
			array_push($batches, $result->batch);
			$rateUnemployment[$result->batch] = $result->ratio;
			$attrition[$result->batch] = $result->dropouts;
		}

		return round($this->getCorrelation($rateUnemployment, $attrition, $batches), 2);
	}

	//Grades - Low Grades (3.00 and below)
	public function corrGrades($level, $levelid = null) {
		$rateGrades = [];
		$attrition = [];
		$batches = [];
		$results = Correlation::getGrades($level, $levelid);

		foreach ($results as $result) {
			array_push($batches, $result->batch);
			$rateGrades[$result->batch] = $result->ratio;
			$attrition[$result->batch] = $result->dropouts;
		}

		return round($this->getCorrelation($rateGrades, $attrition, $batches), 2);
	}

	//Grades - High Grades (3.00 and below)
	public function corrHighGrades($level, $levelid = null) {
		$rateHighGrades = [];
		$attrition = [];
		$batches = [];
		$results = Correlation::getHighGrades($level, $levelid);

		foreach ($results as $result) {
			array_push($batches, $result->batch);
			$rateHighGrades[$result->batch] = $result->ratio;
			$attrition[$result->batch] = $result->dropouts;
		}

		return round($this->getCorrelation($rateHighGrades, $attrition, $batches), 2);
	}

	//ST Bracket - Poor Students (B and above)
	public function corrStbracket($level, $levelid = null) {
		$rateStbracket = [];
		$attrition = [];
		$rateStbracket = [];
		$attrition = [];
		$batches = [];
		$results = Correlation::getStbracket($level, $levelid);

		foreach ($results as $result) {
			array_push($batches, $result->batch);
			$rateStbracket[$result->batch] = $result->ratio;
			$attrition[$result->batch] = $result->dropouts;
		}

		return round($this->getCorrelation($rateStbracket, $attrition, $batches), 2);
	}

	//Region - Students who live far (Visayas, Mindanao)
	public function corrRegion($level, $levelid = null) {
		$rateRegion = [];
		$attrition = [];
		$batches = [];
		$results = Correlation::getRegion($level, $levelid);

		foreach ($results as $result) {
			array_push($batches, $result->batch);
			$rateRegion[$result->batch] = $result->ratio;
			$attrition[$result->batch] = $result->dropouts;
		}

		return round($this->getCorrelation($rateRegion, $attrition, $batches), 2);
	}

	//Units - Underloaded students
	public function corrUnits($level, $levelid = null) {
		$rateUnits = [];
		$attrition = [];
		$batches = [];
		$results = Correlation::getUnits($level, $levelid);

		foreach ($results as $result) {
			array_push($batches, $result->batch);
			$rateUnits[$result->batch] = $result->ratio;
			$attrition[$result->batch] = $result->dropouts;
		}

		return round($this->getCorrelation($rateUnits, $attrition, $batches), 2);
	}

	//Overloading - Overloaded students
	public function corrOverloading($level, $levelid = null) {
		$rateOverloading = [];
		$attrition = [];
		$batches = [];
		$results = Correlation::getOverloading($level, $levelid);

		foreach ($results as $result) {
			array_push($batches, $result->batch);
			$rateOverloading[$result->batch] = $result->ratio;
			$attrition[$result->batch] = $result->dropouts;
		}

		return round($this->getCorrelation($rateOverloading, $attrition, $batches), 2);
	}

	//Specific College
	public function showCollege() {
		$id = Input::get('college-dropdown');
		$level = 'college';
		$levelName = DB::table('units')->select('unitname')->where('unitid', $id)->first()->unitname;

		//Factors names
		$factors = Factor::select('factorid', 'factorname')->get();
		$factorNames = [];
		foreach ($factors as $factor) {
			$factorNames[$factor->factorid] = $factor->factorname;
		}

		$rawCorrelation[$level][1] = $this->corrEmployment($level, $id);
		if ($rawCorrelation[$level][1] < 0)
			$correlation[$level][1] = -$rawCorrelation[$level][1];
		else
			$correlation[$level][1] = $rawCorrelation[$level][1];

		$rawCorrelation[$level][2] = $this->corrGrades($level, $id);
		if ($rawCorrelation[$level][2] < 0)
			$correlation[$level][2] = -$rawCorrelation[$level][2];
		else
			$correlation[$level][2] = $rawCorrelation[$level][2];

		$rawCorrelation[$level][3] = $this->corrStbracket($level, $id);
		if ($rawCorrelation[$level][3] < 0)
			$correlation[$level][3] = -$rawCorrelation[$level][3];
		else
			$correlation[$level][3] = $rawCorrelation[$level][3];

		$rawCorrelation[$level][4] = $this->corrRegion($level, $id);
		if ($rawCorrelation[$level][4] < 0)
			$correlation[$level][4] = -$rawCorrelation[$level][4];
		else
			$correlation[$level][4] = $rawCorrelation[$level][4];

		$rawCorrelation[$level][6] = $this->corrUnits($level, $id);
		if ($rawCorrelation[$level][6] < 0)
			$correlation[$level][6] = -$rawCorrelation[$level][6];
		else
			$correlation[$level][6] = $rawCorrelation[$level][6];

		$rawCorrelation[$level][8] = $this->corrUnemployment($level, $id);
		if ($rawCorrelation[$level][8] < 0)
			$correlation[$level][8] = -$rawCorrelation[$level][8];
		else
			$correlation[$level][8] = $rawCorrelation[$level][8];

		$rawCorrelation[$level][7] = $this->corrHighGrades($level, $id);
		if ($rawCorrelation[$level][7] < 0)
			$correlation[$level][7] = -$rawCorrelation[$level][7];
		else
			$correlation[$level][7] = $rawCorrelation[$level][7];

		$rawCorrelation[$level][9] = $this->corrOverloading($level, $id);
		if ($rawCorrelation[$level][9] < 0)
			$correlation[$level][9] = -$rawCorrelation[$level][9];
		else
			$correlation[$level][9] = $rawCorrelation[$level][9];

		return View::make('correlation.correlation-specific', compact('rawCorrelation', 'correlation', 'levelName', 'factorNames', 'level'));
	}

	//Specific Department
	public function showDepartment() {
		$id = Input::get('department-dropdown');
		$level = 'department';
		$levelName = DB::table('units')->select('unitname')->where('unitid', $id)->first()->unitname;

		//Factors names
		$factors = Factor::select('factorid', 'factorname')->get();
		$factorNames = [];
		foreach ($factors as $factor) {
			$factorNames[$factor->factorid] = $factor->factorname;
		}

		$rawCorrelation[$level][1] = $this->corrEmployment($level, $id);
		if ($rawCorrelation[$level][1] < 0)
			$correlation[$level][1] = -$rawCorrelation[$level][1];
		else
			$correlation[$level][1] = $rawCorrelation[$level][1];

		$rawCorrelation[$level][2] = $this->corrGrades($level, $id);
		if ($rawCorrelation[$level][2] < 0)
			$correlation[$level][2] = -$rawCorrelation[$level][2];
		else
			$correlation[$level][2] = $rawCorrelation[$level][2];

		$rawCorrelation[$level][3] = $this->corrStbracket($level, $id);
		if ($rawCorrelation[$level][3] < 0)
			$correlation[$level][3] = -$rawCorrelation[$level][3];
		else
			$correlation[$level][3] = $rawCorrelation[$level][3];

		$rawCorrelation[$level][4] = $this->corrRegion($level, $id);
		if ($rawCorrelation[$level][4] < 0)
			$correlation[$level][4] = -$rawCorrelation[$level][4];
		else
			$correlation[$level][4] = $rawCorrelation[$level][4];

		$rawCorrelation[$level][6] = $this->corrUnits($level, $id);
		if ($rawCorrelation[$level][6] < 0)
			$correlation[$level][6] = -$rawCorrelation[$level][6];
		else
			$correlation[$level][6] = $rawCorrelation[$level][6];

		$rawCorrelation[$level][8] = $this->corrUnemployment($level, $id);
		if ($rawCorrelation[$level][8] < 0)
			$correlation[$level][8] = -$rawCorrelation[$level][8];
		else
			$correlation[$level][8] = $rawCorrelation[$level][8];

		$rawCorrelation[$level][7] = $this->corrHighGrades($level, $id);
		if ($rawCorrelation[$level][7] < 0)
			$correlation[$level][7] = -$rawCorrelation[$level][7];
		else
			$correlation[$level][7] = $rawCorrelation[$level][7];

		$rawCorrelation[$level][9] = $this->corrOverloading($level, $id);
		if ($rawCorrelation[$level][9] < 0)
			$correlation[$level][9] = -$rawCorrelation[$level][9];
		else
			$correlation[$level][9] = $rawCorrelation[$level][9];

		return View::make('correlation.correlation-specific', compact('rawCorrelation', 'correlation', 'levelName', 'factorNames', 'level'));
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
