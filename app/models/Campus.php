<?php


class Campus extends Eloquent {

    protected $table = 'units';
    protected $primaryKey = 'unitid';
    public $timestamps = false;

    //Get average attrition
	public function getAveAttrition() {
		$sumAttrition = 0;
		$batches = [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009];
		$batchAttrs = $this->getBatchAttrition();

		foreach ($batches as $batch) {
			$sumAttrition = $sumAttrition + $batchAttrs[$batch];
		}

		$aveAttrition = round($sumAttrition / 10, 2);
		return $aveAttrition;
	}

	//Get batch attrition
	public function getBatchAttrition() {
		$batchAttrition = [];
		$batches = [200000000, 200100000, 200200000, 200300000, 200400000, 200500000, 200600000, 200700000, 200800000, 200900000];

		foreach ($batches as $batch) {
			$allBatchDropouts = Studentdropout::getBatchDropoutsCount($batch);
			$allBatchStudents = Studentterm::getBatchStudentsCount($batch);
            $allBatchDelayed = Studentdelayed::getBatchDelayedCount($batch);

			$batchAttrition[$batch / 100000] = round((($allBatchDropouts + $allBatchDelayed) / $allBatchStudents) * 100, 2);
		}

		return $batchAttrition;
	}

    //Get average delay rate
	public function getAveDelayed() {
        //changed to rate
		$sumDelayed = 0;
		$batches = [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009];
		$batchDelayed = $this->getBatchDelayed();

		foreach ($batches as $batch) {
			$sumDelayed = $sumDelayed + $batchDelayed[$batch];
		}

		$aveDelayed = round($sumDelayed / 10, 2);
		return $aveDelayed;
	}

    //Get batch delayed
    public function getBatchDelayed() {
        $batchDelayed = [];
        $batches = [200000000, 200100000, 200200000, 200300000, 200400000, 200500000, 200600000, 200700000, 200800000, 200900000];

        foreach ($batches as $batch) {
            /*$delayedRaw = Studentdropout::getBatchDropouts($batch);
            $allBatchDelayed = 0;

            foreach ($delayedRaw as $delayRaw) {
                $studentid = $delayRaw->studentid;
                $semesters = Studentdropout::select('semesters')->where('studentid', $studentid)->first()->semesters;
                $realYears = Program::select('numyears')->where('programid', Studentdropout::select('programid')->where('studentid', $studentid)->first()->programid)->first()->numyears;

                if ($semesters > $realYears * 2)
                    $allBatchDelayed = $allBatchDelayed + 1;
            }*/

            $allBatchDelayed = Studentdelayed::getBatchDelayedCount($batch);
            $allBatchStudents = Studentterm::getBatchStudentsCount($batch);

            $batchDelayed[$batch / 100000] = round(($allBatchDelayed / $allBatchStudents) * 100, 2);
        }

        return $batchDelayed;
    }

	//Get average number of dropouts (rate)
	public function getAveDropouts() {
        //changed to rate
		$sumDropouts = 0;
		$batches = [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009];
		$batchDropouts = $this->getBatchDropouts();

		foreach ($batches as $batch) {
			$sumDropouts = $sumDropouts + $batchDropouts[$batch];
		}

		$aveAttrition = round($sumDropouts / 10, 2);
		return $aveAttrition;
	}

	//Get batch number of dropouts (rate)
	public function getBatchDropouts() {
		$batchDropouts = [];
		$batches = [200000000, 200100000, 200200000, 200300000, 200400000, 200500000, 200600000, 200700000, 200800000, 200900000];

		foreach ($batches as $batch) {
            $allBatchStudents = Studentterm::getBatchStudentsCount($batch);
            $allBatchDropouts = Studentdropout::getBatchDropoutsCount($batch);
			$batchDropouts[$batch / 100000] = round(($allBatchDropouts / $allBatchStudents) * 100, 2);
		}

		return $batchDropouts;
	}

	//Get average number of students per year
	public function getStudentAverage() {
		$yearsArray = Year::where('year','>', 1999)->where('year', '<', 2014)->get();
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
			1. get number of students with studentterms, remove dropouts
			2. get number of years of each student by dividing number of terms by 3
			3. get average of step 2 (accdng to a site, sum/count is faster than avg command)
		*/
		$numberOfYearsPerStudent = Studentterm::getNumberofYears();
		$numberOfStudents = count($numberOfYearsPerStudent);

		$totalYears = 0;
		foreach($numberOfYearsPerStudent as $key => $val){
			$totalYears = $totalYears + $val->numyears;
		}

		$aveYearsOfStay = round($totalYears/$numberOfStudents, 2);
		return $aveYearsOfStay;
	}

	//Get average years before dropping out
	public function getAveYearsBeforeDropout(){
        //Get list of dropouts who has this program as their last program before dropping out.
        $programids = Program::whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $dropouts = DB::table('studentdropouts')->whereIn('lastprogramid', $programids)->lists('studentid');


        $sumYears = 0;
        foreach($dropouts as $dropout){
            $sems = DB::table('studentterms')->where('studentid', $dropout)->whereIn('programid', $programids)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->count();
            $years = $sems/2;
            $sumYears = $sumYears + $years;
        }
        if(count($dropouts) != 0){
            $aveYears = $sumYears/(count($dropouts));
        }
        else{
            $aveYears = 0;
        }
        return round($aveYears, 2);
    }

    public function getEmploymentCount(){
        $employmentArray = [];
        $programids = Program::whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $collegeDropouts = Studentdropout::whereIn('lastprogramid', $programids)->get();
        $dropoutCount = count($collegeDropouts);
        $employed = 0;
        $unemployed = 0;

        foreach($collegeDropouts as $dropout){
            $results = Studentterm::getOneEmployment($dropout->studentid);
            foreach ($results as $result) {
                if ((strpos($result->employment, 'F') !== false) || (strpos($result->employment, 'P') !== false)){
                    $employed++;
                    break;
                }
            }
        }

        $unemployed = $dropoutCount - $employed;
        $employmentArray['Employed'] = round(($employed/$dropoutCount)*100, 2);
        $employmentArray['Unemployed'] = round(($unemployed/$dropoutCount)*100, 2);

        return $employmentArray;
    }

    public function getSpecificBatchEmploymentCount($batch){ //format is year
        $batch = $batch*100000;
        $batchEnd = $batch + 100000;

        $employmentArray = [];
        $programids = Program::whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $collegeDropouts = Studentdropout::whereIn('lastprogramid', $programids)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $dropoutCount = count($collegeDropouts);
        $employed = 0;
        $unemployed = 0;

        foreach($collegeDropouts as $dropout){
            $results = Studentterm::getOneEmployment($dropout->studentid);
            foreach ($results as $result) {
                if ((strpos($result->employment, 'F') !== false) || (strpos($result->employment, 'P') !== false)){
                    $employed++;
                    break;
                }
            }
        }

        $unemployed = $dropoutCount - $employed;
        $employmentArray['Employed'] = round(($employed/$dropoutCount)*100, 2);
        $employmentArray['Unemployed'] = round(($unemployed/$dropoutCount)*100, 2);
        return $employmentArray;
    }

    public function getGradeCount(){
        $gradeArray = [];
        $programids = Program::whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $collegeDropouts = Studentdropout::whereIn('lastprogramid', $programids)->get();
        $dropoutCount = count($collegeDropouts);
        $passed = 0;
        $failed = 0;

        foreach($collegeDropouts as $dropout){
            $aveGWA = Studentterm::select('gwa')->where('studentid', $dropout->studentid)->whereIn('programid', $programids)->where('gwa', '>', 0)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->avg('gwa');

            if($aveGWA > 3.00){
                $failed++;
            }
        }

        $passed = $dropoutCount - $failed;
        $gradeArray['1.00 - 3.00'] = round(($passed/$dropoutCount)*100, 2);
        $gradeArray['Below 3.00'] = round(($failed/$dropoutCount)*100, 2);
        return $gradeArray;
    }

    public function getSpecificBatchGradeCount($batch){
        $batch = $batch*100000;
        $batchEnd = $batch + 100000;

        $gradeArray = [];
        $programids = Program::whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $collegeDropouts = Studentdropout::whereIn('lastprogramid', $programids)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $dropoutCount = count($collegeDropouts);
        $passed = 0;
        $failed = 0;

        foreach($collegeDropouts as $dropout){
            $aveGWA = Studentterm::select('gwa')->where('studentid', $dropout->studentid)->whereIn('programid', $programids)->where('gwa', '>', 0)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->avg('gwa');

            if($aveGWA > 3.00){
                $failed++;
            }
        }

        $passed = $dropoutCount - $failed;
        $gradeArray['1.00 - 3.00'] = round(($passed/$dropoutCount)*100, 2);
        $gradeArray['Below 3.00'] = round(($failed/$dropoutCount)*100, 2);
        return $gradeArray;
    }

    public function getSTBracketCount(){
        $bracketArray = [];
        $programids = Program::whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $collegeDropouts = Studentdropout::whereIn('lastprogramid', $programids)->get();
        $bracketA = 0;
        $bracketB = 0;
        $bracketC = 0;
        $bracketD = 0;
        $bracketE1 = 0;
        $bracketE2 = 0;
        $unstated = 0;

        foreach($collegeDropouts as $dropout){
            $results = Studentterm::select('stfapbracket')->where('studentid', $dropout->studentid)->whereIn('programid', $programids)->groupBy('stfapbracket')->lists('stfapbracket');
            $results = array_unique($results);
            //var_dump('Dropout: '. $dropout->studentid);
            //var_dump($results);
            foreach ($results as $result){
                switch($result){
                    case (strpos($result, 'A') !== false || strpos($result, '9') !== false):
                        $bracketA++;
                        break;
                    case (strpos($result, 'B') !== false):
                        $bracketB++;
                        break;
                    case (strpos($result, 'C') !== false):
                        $bracketC++;
                        break;
                    case (strpos($result, 'D') !== false):
                        $bracketD++;
                        break;
                    case (strpos($result, 'E1') !== false):
                        $bracketE1++;
                        break;
                    case (strpos($result, 'E2') !== false || strpos($result, '1') !== false):
                        $bracketE2++;
                        break;
                    default:
                        $unstated++;
                }
            }
        }

        $bracketArray["A"] = $bracketA;
        $bracketArray["B"] = $bracketB;
        $bracketArray["C"] = $bracketC;
        $bracketArray["D"] = $bracketD;
        $bracketArray["E1"] = $bracketE1;
        $bracketArray["E2"] = $bracketE2;
        $bracketArray["Unstated"] = $unstated;
        return $bracketArray;
    }

    public function getSpecificBatchSTBracketCount($batch){
        $batch = $batch*100000;
        $batchEnd = $batch + 100000;

        $bracketArray = [];
        $programids = Program::whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $collegeDropouts = Studentdropout::whereIn('lastprogramid', $programids)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $bracketA = 0;
        $bracketB = 0;
        $bracketC = 0;
        $bracketD = 0;
        $bracketE1 = 0;
        $bracketE2 = 0;
        $unstated = 0;

        foreach($collegeDropouts as $dropout){
            $results = Studentterm::select('stfapbracket')->where('studentid', $dropout->studentid)->whereIn('programid', $programids)->groupBy('stfapbracket')->lists('stfapbracket');
            $results = array_unique($results);
            foreach ($results as $result){
                switch($result){
                    case (strpos($result, 'A') !== false || strpos($result, '9') !== false):
                        $bracketA++;
                        break;
                    case (strpos($result, 'B') !== false):
                        $bracketB++;
                        break;
                    case (strpos($result, 'C') !== false):
                        $bracketC++;
                        break;
                    case (strpos($result, 'D') !== false):
                        $bracketD++;
                        break;
                    case (strpos($result, 'E1') !== false):
                        $bracketE1++;
                        break;
                    case (strpos($result, 'E2') !== false || strpos($result, '1') !== false):
                        $bracketE2++;
                        break;
                    default:
                        $unstated++;
                }
            }
        }

        $bracketArray["A"] = $bracketA;
        $bracketArray["B"] = $bracketB;
        $bracketArray["C"] = $bracketC;
        $bracketArray["D"] = $bracketD;
        $bracketArray["E1"] = $bracketE1;
        $bracketArray["E2"] = $bracketE2;
        $bracketArray["Unstated"] = $unstated;
        return $bracketArray;
    }

    public function getRegionCount(){
        $regionArray = [];
        $programids = Program::whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $collegeDropouts = Studentdropout::whereIn('lastprogramid', $programids)->get();
        $luzon = 0;
        $visayas = 0;
        $mindanao = 0;
        $unstated = 0;

        $luzonRegions = ['NCR', 'I', 'CAR', 'II', 'III', 'IV', 'V'];
        $visayasRegions = ['VI', 'VII', 'VIII'];
        $mindanaoRegions = ['IX', 'X', 'XI', 'XII', 'XIII', 'ARMM'];

        foreach($collegeDropouts as $dropout){
            $regionHolder = Studentaddress::getOneRegion($dropout->studentid);
            if (count($regionHolder) > 0) {
                $regionCode = preg_replace('/\s+/', '', $regionHolder->regioncode);
                if (in_array($regionCode, $luzonRegions)){
                    $luzon++;
                }
                elseif(in_array($regionCode, $visayasRegions)){
                    $visayas++;
                }
                elseif(in_array($regionCode, $mindanaoRegions)){
                    $mindanao++;
                }
            }
            else{
                $unstated++;
            }
        }

        $regionArray['Luzon'] = $luzon;
        $regionArray['Visayas'] = $visayas;
        $regionArray['Mindanao'] = $mindanao;
        $regionArray['Unstated'] = $unstated;

        return $regionArray;
    }

    public function getSpecificBatchRegionCount($batch){
        $batch = $batch*100000;
        $batchEnd = $batch + 100000;

        $regionArray = [];
        $programids = Program::whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $collegeDropouts = Studentdropout::whereIn('lastprogramid', $programids)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $luzon = 0;
        $visayas = 0;
        $mindanao = 0;
        $unstated = 0;

        $luzonRegions = ['NCR', 'I', 'CAR', 'II', 'III', 'IV', 'V'];
        $visayasRegions = ['VI', 'VII', 'VIII'];
        $mindanaoRegions = ['IX', 'X', 'XI', 'XII', 'XIII', 'ARMM'];

        foreach($collegeDropouts as $dropout){
            $regionHolder = Studentaddress::getOneRegion($dropout->studentid);
            if (count($regionHolder) > 0) {
                $regionCode = preg_replace('/\s+/', '', $regionHolder->regioncode);
                if (in_array($regionCode, $luzonRegions)){
                    $luzon++;
                }
                elseif(in_array($regionCode, $visayasRegions)){
                    $visayas++;
                }
                elseif(in_array($regionCode, $mindanaoRegions)){
                    $mindanao++;
                }
            }
            else{
                $unstated++;
            }
        }

        $regionArray['Luzon'] = $luzon;
        $regionArray['Visayas'] = $visayas;
        $regionArray['Mindanao'] = $mindanao;
        $regionArray['Unstated'] = $unstated;

        return $regionArray;
    }



}
