<?php


class Department extends Eloquent {

    protected $table = 'units';
    protected $primaryKey = 'unitid';

    public $timestamps = false;

    public $studentsSem1Count = 0;
    public $studentsSem2Count = 0;

    public function programs(){
        return $this->hasMany('Program', 'unitid');
    }

    public function studentterms()
    {
        return $this->hasManyThrough('Studentterm', 'Program', 'unitid', 'programid');
    }

    public function college() {
        return $this->belongsTo('College', 'parentunitid');
    }

    public function getAveStudents(){
        $years = Year::all();
        $programs = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->get();
        $sumProgramsAve = 0;
        $sumDepartmentAve = 0;
        foreach($years as $year){
            foreach($programs as $program){
                $currentProgramAve = $program->getYearlyAveStudents($year->year);
                $sumProgramsAve = $sumProgramsAve + $currentProgramAve;
            }
            $currentYearAve = $sumProgramsAve/(count($programs));
            $sumDepartmentAve = $sumDepartmentAve + $currentYearAve;
            $sumProgramsAve = 0;
        }
        $totalDepartmentAve = $sumDepartmentAve/(count($years));
        return round($totalDepartmentAve, 2);
    }

    public function getYearlyAveStudents($year){
        /*$studentsSem1 = $this->studentterms()->where('aysem', strval($year).'1' )
        ->whereHas('program', function($q){
            $q->whereNotIn('programid', array(62, 66, 38, 22));
            $q->where('degreelevel', 'U');
        })->count();

        $studentsSem2 = $this->studentterms()->where('aysem', strval($year).'2' )
        ->whereHas('program', function($q){
            $q->whereNotIn('programid', array(62, 66, 38, 22));
            $q->where('degreelevel', 'U');
        })->count();

        $aveStudents = ($studentsSem1 + $studentsSem2)/2;
        return $aveStudents;*/

        $programs = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->get();
        $sumProgramsAve = 0;
        foreach($programs as $program){
            $currentProgramAve = $program->getYearlyAveStudents($year);
            $sumProgramsAve = $sumProgramsAve + $currentProgramAve;
        }
        $totalAve = $sumProgramsAve/(count($programs));
        return $totalAve;

    }

    public function getYearlySemDifference($year){
        $studentsSem1 = $this->studentterms()->where('aysem', strval($year).'1' )
        ->whereHas('program', function($q){
            $q->whereNotIn('programid', array(62, 66, 38, 22));
            $q->where('degreelevel', 'U');
        })->count();

        $studentsSem2 = $this->studentterms()->where('aysem', strval($year).'2' )
        ->whereHas('program', function($q){
            $q->whereNotIn('programid', array(62, 66, 38, 22));
            $q->where('degreelevel', 'U');
        })->count();

        $semDifference = $studentsSem2 - $studentsSem1;
        return $semDifference;
    }

    public function getAveAttrition(){
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::whereIn('programid', $programids)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        $max = 2009;
        $batches = [];
        foreach($progYears as $progYear){
            if(($progYear > 1999) && ($progYear < ($max + 1))){
                array_push($batches, ($progYear*100000));
            }
        }

        $batchAttrs = $this->getBatchAttrition();
        $sumAttrition = 0;
        $noData = 0;
		foreach ($batches as $batch) {
            $attrData = $batchAttrs[$batch / 100000];
            if($attrData != -1){
                $sumAttrition = $sumAttrition + ($batchAttrs[$batch / 100000]/100);
            }
            else{
                $noData++;
            }
		}
		$aveAttrition = round(($sumAttrition / (count($batches) - $noData)) * 100, 2);
		return $aveAttrition;
    }

    public function getBatchAttrition(){
        $batchAttrition = [];
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::whereIn('programid', $programids)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        $max = 2009;
        $batches = [];
        foreach($progYears as $progYear){
            if(($progYear > 1999) && ($progYear < ($max + 1))){
                array_push($batches, ($progYear*100000));
            }
        }

        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');

        foreach ($batches as $batch) {
            $batchEnd = $batch + 100000;
            $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->whereIn('programid', $programids)->groupBy('studentid')->get());
			$allBatchDropouts = Studentdropout::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->whereIn('lastprogramid', $programids)->count();

            if($allBatchStudents != 0){
                $batchAttrition[$batch / 100000] = round(($allBatchDropouts / $allBatchStudents) * 100, 2);
            }
            else{
                $batchAttrition[$batch / 100000] = -1;
            }
		}

		return $batchAttrition;
    }

    public function getAveShiftRate() {
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::whereIn('programid', $programids)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        $max = 2009;
        $batches = [];
        foreach($progYears as $progYear){
            if(($progYear > 1999) && ($progYear < ($max + 1))){
                array_push($batches, ($progYear*100000));
            }
        }

        $batchShifts = $this->getBatchShiftRate();
        $sumShiftRate = 0;
        $noData = 0;
		foreach ($batches as $batch) {
            $attrData = $batchShifts[$batch / 100000];
            if($attrData != -1){
			     $sumShiftRate = $sumShiftRate +  ($batchShifts[$batch / 100000]/100);
            }
            else{
                $noData++;
            }
		}

		$aveShiftRate = round(($sumShiftRate / (count($batches) - $noData)) * 100, 2);
		return $aveShiftRate;
    }

    public function getBatchShiftRate(){
        $batchShiftRate = [];
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::whereIn('programid', $programids)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        $max = 2009;
        $batches = [];
        foreach($progYears as $progYear){
            if(($progYear > 1999) && ($progYear < ($max + 1))){
                array_push($batches, ($progYear*100000));
            }
        }

        $dropouts = DB::table('studentdropouts')->whereIn('lastprogramid', $programids)->lists('studentid');
        foreach ($batches as $batch) {
            $batchEnd = $batch + 100000;
            $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->whereIn('programid', $programids)->groupBy('studentid')->get());
            $allBatchShiftees = count(DB::table('studentshifts')->join('programs', 'program1id', '=', 'programid')->select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->whereIn('program1id', $programids)->whereNotIn('program2id',  $programids)->where('program2id', '!=', 38)->whereRaw('program1years < CAST(numyears AS numeric)')->whereNotIn('studentid', $dropouts)->groupBy('studentid')->get());
			//$allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->whereIn('program1id', $programids)->whereNotIn('program2id',  $programids)->where('program2id', '!=', 38)->groupBy('studentid')->get());

            if($allBatchStudents != 0){
                $batchShiftRate[$batch / 100000] = round(($allBatchShiftees / $allBatchStudents) * 100, 2);
            }
            else{
                $batchShiftRate[$batch / 100000] = -1;
            }
		}

		return $batchShiftRate;
    }

    public function getProgramsAveBatchAttrition(){
        $programsAveAttrition = [];
        $programs = $this->programs()->whereNotIn('programid', array(62, 66, 22, 38))->where('degreelevel', 'U')->get();

        foreach($programs as $program){
            //$programsAveAttrition[$program->programtitle] = $program->getAveAttrition();
            $programsAveAttrition[$program->programtitle] = $program->ave_batch_attrition;
        }

        return $programsAveAttrition;
    }

    public function getEmploymentCount(){
        $employmentArray = [];
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $departmentDropouts = Studentdropout::whereIn('lastprogramid', $programids)->get();
        $dropoutCount = count($departmentDropouts);
        $employed = 0;
        $unemployed = 0;

        foreach($departmentDropouts as $dropout){
            $results = Studentterm::getOneEmployment($dropout->studentid);
            $duplicate = 0;
            foreach ($results as $result) {
                if ($result->employment === 'F' || $result->employment === 'P'){
                    if($duplicate === 0){
                        $employed++;
                        $duplicate++;
                    }
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
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $departmentDropouts = Studentdropout::whereIn('lastprogramid', $programids)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $dropoutCount = count($departmentDropouts);
        $employed = 0;
        $unemployed = 0;

        foreach($departmentDropouts as $dropout){
            $results = Studentterm::getOneEmployment($dropout->studentid);
            $duplicate = 0;
            foreach ($results as $result) {
                if ($result->employment === 'F' || $result->employment === 'P'){
                    if($duplicate === 0){
                        $employed++;
                        $duplicate++;
                    }
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
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $departmentDropouts = Studentdropout::whereIn('lastprogramid', $programids)->get();
        $dropoutCount = count($departmentDropouts);
        $passed = 0;
        $failed = 0;

        foreach($departmentDropouts as $dropout){
            $aveGWA = Studentterm::select('gwa')->where('studentid', $dropout->studentid)->whereIn('programid', $programids)->where('gwa', '>', 0)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->avg('gwa');

            if($aveGWA > 3.00){
                $failed++;
            }
        }

        $passed = $dropoutCount - $failed;
        $gradeArray['Passed'] = round(($passed/$dropoutCount)*100, 2);
        $gradeArray['Failed'] = round(($failed/$dropoutCount)*100, 2);
        return $gradeArray;
    }

    public function getSpecificBatchGradeCount($batch){
        $batch = $batch*100000;
        $batchEnd = $batch + 100000;

        $gradeArray = [];
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $departmentDropouts = Studentdropout::whereIn('lastprogramid', $programids)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $dropoutCount = count($departmentDropouts);
        $passed = 0;
        $failed = 0;

        foreach($departmentDropouts as $dropout){
            $aveGWA = Studentterm::select('gwa')->where('studentid', $dropout->studentid)->whereIn('programid', $programids)->where('gwa', '>', 0)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->avg('gwa');

            if($aveGWA > 3.00){
                $failed++;
            }
        }

        $passed = $dropoutCount - $failed;
        $gradeArray['Passed'] = round(($passed/$dropoutCount)*100, 2);
        $gradeArray['Failed'] = round(($failed/$dropoutCount)*100, 2);
        return $gradeArray;
    }

    public function getSTBracketCount(){
        $bracketArray = [];
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
	    $departmentDropouts = Studentdropout::whereIn('lastprogramid', $programids)->get();
        $bracketA = 0;
        $bracketB = 0;
        $bracketC = 0;
        $bracketD = 0;
        $bracketE1 = 0;
        $bracketE2 = 0;
        $unstated = 0;

        foreach($departmentDropouts as $dropout){
            $results = Studentterm::select('stfapbracket')->where('studentid', $dropout->studentid)->whereIn('programid', $programids)->groupBy('stfapbracket')->lists('stfapbracket');
            $results = array_unique($results);
            foreach ($results as $result){
                switch($result){
                    case (strpos($result, 'A') !== false):
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
                    case (strpos($result, 'E2') !== false):
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
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $departmentDropouts = Studentdropout::whereIn('lastprogramid', $programids)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $bracketA = 0;
        $bracketB = 0;
        $bracketC = 0;
        $bracketD = 0;
        $bracketE1 = 0;
        $bracketE2 = 0;
        $unstated = 0;

        foreach($departmentDropouts as $dropout){
            $results = Studentterm::select('stfapbracket')->where('studentid', $dropout->studentid)->whereIn('programid', $programids)->groupBy('stfapbracket')->lists('stfapbracket');
            $results = array_unique($results);
            foreach ($results as $result){
                switch($result){
                    case (strpos($result, 'A') !== false):
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
                    case (strpos($result, 'E2') !== false):
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
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
	    $departmentDropouts = Studentdropout::whereIn('lastprogramid', $programids)->get();
        $luzon = 0;
        $visayas = 0;
        $mindanao = 0;
        $unstated = 0;

        $luzonRegions = ['NCR', 'I', 'CAR', 'II', 'III', 'IV', 'V'];
        $visayasRegions = ['VI', 'VII', 'VIII'];
        $mindanaoRegions = ['IX', 'X', 'XI', 'XII', 'XIII', 'ARMM'];

        foreach($departmentDropouts as $dropout){
            $regionHolder = Studentaddress::getOneRegion($dropout->studentid);
            if (count($regionHolder) > 0) {
                if (in_array($regionHolder->regioncode, $luzonRegions)){
                    $luzon++;
                }
                elseif(in_array($regionHolder->regioncode, $visayasRegions)){
                    $visayas++;
                }
                elseif(in_array($regionHolder->regioncode, $mindanaoRegions)){
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
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $departmentDropouts = Studentdropout::whereIn('lastprogramid', $programids)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $luzon = 0;
        $visayas = 0;
        $mindanao = 0;
        $unstated = 0;

        $luzonRegions = ['NCR', 'I', 'CAR', 'II', 'III', 'IV', 'V'];
        $visayasRegions = ['VI', 'VII', 'VIII'];
        $mindanaoRegions = ['IX', 'X', 'XI', 'XII', 'XIII', 'ARMM'];

        foreach($departmentDropouts as $dropout){
            $regionHolder = Studentaddress::getOneRegion($dropout->studentid);
            if (count($regionHolder) > 0) {
                if (in_array($regionHolder->regioncode, $luzonRegions)){
                    $luzon++;
                }
                elseif(in_array($regionHolder->regioncode, $visayasRegions)){
                    $visayas++;
                }
                elseif(in_array($regionHolder->regioncode, $mindanaoRegions)){
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

    public function getShiftGradeCount(){
        //To get batches of program whithin 2000-2009
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::whereIn('programid', $programids)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        if($this->revisionyear > 2009){
            $max = 2012;
        }
        else{
            if($this->programid == 28){
                $max = 2013 - 4;
            }
            else{
                $max = 2013 - $this->numyears;
            }
        }

        $batches = [];
        foreach($progYears as $progYear){
            if(($progYear > 1999) && ($progYear < ($max + 1))){
                array_push($batches, ($progYear*100000));
            }
        }

        $min = min($batches);
        $max = max($batches) + 100000;

        $gradeArray = [];
        $dropouts = DB::table('studentdropouts')->whereIn('lastprogramid', $programids)->lists('studentid');

        $programShiftees = DB::table('studentshifts')->join('programs', 'program1id', '=', 'programid')->select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->whereIn('program1id', $programids)->whereNotIn('program2id',  $programids)->where('program2id', '!=', 38)->whereRaw('program1years < CAST(numyears AS numeric)')->whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');

        $programShiftees = array_unique($programShiftees);
        $shifteeCount = count($programShiftees);
        $passed = 0;
        $failed = 0;

        foreach($programShiftees as $shifteeid){
            $aveGWA = Studentterm::select('gwa')->where('studentid', $shifteeid)->whereIn('programid', $programids)->where('gwa', '>', 0)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->avg('gwa');

            if($aveGWA > 3.00){
                $failed++;
            }
        }

        if($shifteeCount != 0){
            $passed = $shifteeCount - $failed;
            $gradeArray['Passed'] = round(($passed/$shifteeCount)*100, 2);
            $gradeArray['Failed'] = round(($failed/$shifteeCount)*100, 2);
        }
        else{
            $gradeArray['No Shiftees'] = 0;
        }

        return $gradeArray;
    }

    public function getSpecificBatchShiftGradeCount($batch){
        $min = $batch*100000;
        $max = $batch + 100000;

        $gradeArray = [];

        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $dropouts = DB::table('studentdropouts')->whereIn('lastprogramid', $programids)->lists('studentid');
        $programShiftees = DB::table('studentshifts')->join('programs', 'program1id', '=', 'programid')->select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->whereIn('program1id', $programids)->whereNotIn('program2id',  $programids)->where('program2id', '!=', 38)->whereRaw('program1years < CAST(numyears AS numeric)')->whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');

        $programShiftees = array_unique($programShiftees);
        $shifteeCount = count($programShiftees);
        $passed = 0;
        $failed = 0;

        foreach($programShiftees as $shifteeid){
            $aveGWA = Studentterm::select('gwa')->where('studentid', $shifteeid)->whereIn('programid', $programids)->where('gwa', '>', 0)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->avg('gwa');

            if($aveGWA > 3.00){
                $failed++;
            }
        }

        if($shifteeCount != 0){
            $passed = $shifteeCount - $failed;
            $gradeArray['Passed'] = round(($passed/$shifteeCount)*100, 2);
            $gradeArray['Failed'] = round(($failed/$shifteeCount)*100, 2);
        }
        else{
            $gradeArray['No Shiftees'] = 0;
        }

        return $gradeArray;
    }

    public function getShiftSTBracketCount(){
        $bracketArray = [];

        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::whereIn('programid', $programids)->groupBy('year')->orderBy('year', 'asc')->lists('year');

        if($this->revisionyear > 2009){
            $max = 2012;
        }
        else{
            if($this->programid == 28){
                $max = 2013 - 4;
            }
            else{
                $max = 2013 - $this->numyears;
            }
        }

        $batches = [];
        foreach($progYears as $progYear){
            if(($progYear > 1999) && ($progYear < ($max + 1))){
                array_push($batches, ($progYear*100000));
            }
        }

        $min = min($batches);
        $max = max($batches) + 100000;

        $dropouts = DB::table('studentdropouts')->whereIn('lastprogramid', $programids)->lists('studentid');
        $programShiftees = DB::table('studentshifts')->join('programs', 'program1id', '=', 'programid')->select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->whereIn('program1id', $programids)->whereNotIn('program2id',  $programids)->where('program2id', '!=', 38)->whereRaw('program1years < CAST(numyears AS numeric)')->whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');

        $programShiftees = array_unique($programShiftees);

        $bracketA = 0;
        $bracketB = 0;
        $bracketC = 0;
        $bracketD = 0;
        $bracketE1 = 0;
        $bracketE2 = 0;
        $unstated = 0;

        foreach($programShiftees as $shiftee){
            $results = Studentterm::select('stfapbracket')->where('studentid', $shiftee)->whereIn('programid', $programids)->groupBy('stfapbracket')->lists('stfapbracket');
            $results = array_unique($results);
            foreach ($results as $result){
                switch($result){
                    case (strpos($result, 'A') !== false):
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
                    case (strpos($result, 'E2') !== false):
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

    public function getShiftSpecificBatchSTBracketCount($batch){
        $min = $batch*100000;
        $max = $batch + 100000;

        $bracketArray = [];

        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');

        $dropouts = DB::table('studentdropouts')->whereIn('lastprogramid', $programids)->lists('studentid');
        $programShiftees = DB::table('studentshifts')->join('programs', 'program1id', '=', 'programid')->select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->whereIn('program1id', $programids)->whereNotIn('program2id',  $programids)->where('program2id', '!=', 38)->whereRaw('program1years < CAST(numyears AS numeric)')->whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');

        $programShiftees = array_unique($programShiftees);

        $bracketA = 0;
        $bracketB = 0;
        $bracketC = 0;
        $bracketD = 0;
        $bracketE1 = 0;
        $bracketE2 = 0;
        $unstated = 0;

        foreach($programShiftees as $shiftee){
            $results = Studentterm::select('stfapbracket')->where('studentid', $shiftee)->whereIn('programid', $programids)->groupBy('stfapbracket')->lists('stfapbracket');
            foreach ($results as $result){
                switch($result){
                    case (strpos($result, 'A') !== false):
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
                    case (strpos($result, 'E2') !== false):
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

    public function getAveYearsBeforeDropout(){
        //Get list of dropouts who has this program as their last program before dropping out.
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
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

    public function getAveYearsBeforeShifting(){
        //To get batches of program whithin 2000-2009
        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->lists('programid');
        $progYears = Studentterm::whereIn('programid', $programids)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        if($this->revisionyear > 2009){
            $max = 2013;
        }
        else{
            if($this->programid == 28){
                $max = 2013 - 4;
            }
            else{
                $max = 2013 - $this->numyears;
            }
        }

        $batches = [];
        foreach($progYears as $progYear){
            if(($progYear > 1999) && ($progYear < ($max + 1))){
                array_push($batches, ($progYear*100000));
            }
        }

        $min = min($batches);
        $max = max($batches) + 100000;

        $dropouts = DB::table('studentdropouts')->where('studentid', '>', $min)->where('studentid', '<', $max)->whereIn('lastprogramid', $programids)->lists('studentid');

        $shiftees = DB::table('studentshifts')->join('programs', 'program1id', '=', 'programid')->select('studentid', 'program1years')->where('studentid', '>', $min)->where('studentid', '<', $max)->whereIn('program1id', $programids)->whereNotIn('program2id',  $programids)->where('program2id', '!=', 38)->whereRaw('program1years < CAST(numyears AS numeric)')->whereNotIn('studentid', $dropouts)->get();

        $sumYears = 0;
        foreach($shiftees as $shiftee){
            $sumYears = $sumYears + $shiftee->program1years;
        }
        if(count($shiftees) != 0){
            $aveYears = $sumYears/(count($shiftees));
        }
        else{
            $aveYears = 0;
        }
        return round($aveYears, 2);
    }


}
