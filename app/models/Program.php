<?php

class Program extends Eloquent {

    protected $table = 'programs';
    protected $primaryKey = 'programid';

    public function studentterms(){
        return $this->hasMany('Studentterm', 'programid');
    }

    public function department(){
        return $this->belongsTo('Department', 'unitid');
    }

    public function getAveStudents(){
        $years = Year::all();
        $numberOfStudents = 0;
        $zeroStudents = 0;
        foreach($years as $year){
            $studentCount = $this->getYearlyAveStudents($year->year);
            if($studentCount === 0){
                $zeroStudents++;
            }
            $numberOfStudents = $numberOfStudents + $studentCount;
        }
        return $totalAve = $numberOfStudents/(count($years)-$zeroStudents);
    }

    public function getYearlyAveStudents($year){
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        if($this->revisionyear > 2009){
            $max = 2013;
        }
        else{
            if($this->programid === 28){
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

        $studentsSem1 = $this->studentterms()->where('studentid', '>', $min)->where('studentid', '<', $max)->where('aysem', strval($year).'1' )->count();
        $studentsSem2 = $this->studentterms()->where('studentid', '>', $min)->where('studentid', '<', $max)->where('aysem', strval($year).'2' )->count();

        if($this->programid === 28){
            $domProgram = Program::where('programid', 38)->first();
            $domSem1 = $domProgram->studentterms()->where('studentid', '>', $min)->where('studentid', '<', $max)->whereIn('yearlevel', array(3,4))->where('aysem', strval($year).'1' )->count();
            $domSem2 = $domProgram->studentterms()->where('studentid', '>', $min)->where('studentid', '<', $max)->whereIn('yearlevel', array(3,4))->where('aysem', strval($year).'2' )->count();

            $studentsSem1 = $studentsSem1 + $domSem1;
            $studentsSem2 = $studentsSem2 + $domSem2;
        }

        $aveStudents = ($studentsSem1 + $studentsSem2)/2;
        return $aveStudents;
    }

    public function getYearlySemDifference($year){
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        if($this->revisionyear > 2009){
            $max = 2013;
        }
        else{
            if($this->programid === 28){
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

        $studentsSem1 = $this->studentterms()->where('studentid', '>', $min)->where('studentid', '<', $max)->where('aysem', strval($year).'1' )->count();
        $studentsSem2 = $this->studentterms()->where('studentid', '>', $min)->where('studentid', '<', $max)->where('aysem', strval($year).'2' )->count();

        if($this->programid === 28){
            $domProgram = Program::where('programid', 38)->first();
            $domSem1 = $domProgram->studentterms()->where('studentid', '>', $min)->where('studentid', '<', $max)->whereIn('yearlevel', array(3,4))->where('aysem', strval($year).'1' )->count();
            $domSem2 = $domProgram->studentterms()->where('studentid', '>', $min)->where('studentid', '<', $max)->whereIn('yearlevel', array(3,4))->where('aysem', strval($year).'2' )->count();

            $studentsSem1 = $studentsSem1 + $domSem1;
            $studentsSem2 = $studentsSem2 + $domSem2;
        }

        $semDifference = $studentsSem2 - $studentsSem1;
        return $semDifference;
    }

    public function getAveYearsOfStay(){
        //By default, max batch will be 2009. If revision year is greater than 2009, max batch will be revisionyear.
        if($this->revisionyear > 2009){
            $max = ($this->revisionyear)*100000;
        }
        else{
            if($this->programid === 28){
                $max = ((2013 - 4) + 1)*100000;
            }
            else{
                $max = ((2013 - $this->numyears) + 1)*100000;
            }
        }
        //Get list of students from shift table whose progam 1 is this program and whose program1years are less than numyears of program. place their studentids in an array. Exclude them from computation.
        if($this->programid === 28){
            $shiftees = DB::table('studentshifts')->where('program1id', '=', $this->programid)->where(DB::raw('program1years + program2years'), '<', 4)->lists('studentid');
        }
        else{
            $shiftees = DB::table('studentshifts')->where('program1id', '=', $this->programid)->where('program1years', '<', $this->numyears)->lists('studentid');
        }

        //Get list of dropouts. Remove them from computation.
        $dropouts = DB::table('studentdropouts')->lists('studentid');

        if($this->programid === 28){
            $studentids = DB::table('studentterms')->select('studentid')->where('programid', $this->programid)->where('studentid', '>', '200000000')->where('studentid', '<', $max)->whereNotIn('studentid', $dropouts)->whereNotIn('studentid', $shiftees)->groupBy('studentid')->lists('studentid');

            $totalYears = 0;
            foreach($studentids as $studentid){
                //check if student shifted to Doctor of Medicine
                //if he shifted to DoM and if his number of years in (intarmed + DoM) is greater than 4 then let his stay be 4
                //else get his real years of stay
                $dom = Studentshift::where('studentid', $studentid)->where('program1id', 28)->where('program2id', 38)->first();

                if($dom != NULL){ //if record exists
                    $numYears = $dom->program1years + $dom->program2years;
                    if($numYears >= 4){
                        $numYears = 4;
                    }
                }
                else{
                    $numYears = (DB::table('studentterms')->where('studentid', $studentid)->where('programid', $this->programid)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->count())/2;
                }
                $totalYears = $totalYears + $numYears;
            }
            $aveYearsOfStay = round($totalYears/count($studentids), 2);
        }
        else{
            $numberOfYearsPerStudent = DB::table('studentterms')->select(DB::raw('COUNT(*)/2 as numYears'))->where('programid', $this->programid)->where('studentid', '>', '200000000')->where('studentid', '<', $max)->whereNotIn('studentid', $dropouts)->whereNotIn('studentid', $shiftees)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->groupBy('studentid')->get();

            $numberOfStudents = count($numberOfYearsPerStudent);

            $totalYears = 0;
    		foreach($numberOfYearsPerStudent as $key => $val){
    			$totalYears = $totalYears + $val->numyears;
    		}

    		$aveYearsOfStay = round($totalYears/$numberOfStudents, 2);
        }


		return $aveYearsOfStay;
    }

    public function getAveYearsBeforeShifting(){
        //Get list of dropouts who has this program as their last program before dropping out. Remove them from computation.
        //$dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');

        //Get list of students from shift table whose progam 1 is this program and whose program1years are less than numyears of program. place their studentids in an array.

        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        if($this->revisionyear > 2009){
            $max = 2013;
        }
        else{
            if($this->programid === 28){
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

        $dropouts = DB::table('studentdropouts')->where('studentid', '>', '200000000')->where('studentid', '<', $max)->where('lastprogramid', $this->programid)->lists('studentid');

        if($this->programid === 28){
            $shiftees = DB::table('studentshifts')->where('studentid', '>', '200000000')->where('studentid', '<', $max)->where('program1id', '=', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->get();
            $domShiftees = DB::table('studentshifts')->where('studentid', '>', '200000000')->where('studentid', '<', $max)->whereNotIn('studentid', $dropouts)->where('program1id', '=', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->get();

            foreach($domShiftees as $domShiftee) {
                array_push($shiftees, $domShiftee);
            }
        }
        else{
            $shiftees = DB::table('studentshifts')->where('studentid', '>', '200000000')->where('studentid', '<', $max)->where('program1id', '=', $this->programid)->where('program1years', '<', $this->numyears)->get();
        }

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

    public function getAveYearsBeforeDropout(){
        //Get list of dropouts who has this program as their last program before dropping out.
        if($this->programid === 28){
            $dropouts = DB::table('studentdropouts')->where('programid', $this->programid)->lists('studentid');
        }
        else{
            $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');
        }

        $sumYears = 0;
        foreach($dropouts as $dropout){
            $sems = DB::table('studentterms')->where('studentid', $dropout)->where('programid', $this->programid)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->count();
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

    //Get total average attrition
	public function getAveAttrition() {
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        if($this->revisionyear > 2009){
            $max = 2012; //For applied physics, include 2011 and 2012
        }
        else{
            if($this->programid === 28){
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

		$batchAttrs = $this->getBatchAttrition();
        $sumAttrition = 0;
		foreach ($batches as $batch) {
             $sumAttrition = $sumAttrition + ($batchAttrs[$batch / 100000]/100);
		}
		$aveAttrition = round(($sumAttrition / count($batches)) * 100, 2);
		return $aveAttrition;
	}

	//Get batch attrition
    //Ex. Get students from batch 20000 whose last program before dropping out is this program
	public function getBatchAttrition() {
		$batchAttrition = [];
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        if($this->revisionyear > 2009){
            $max = 2012;
        }
        else{
            if($this->programid === 28){
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

		foreach ($batches as $batch) {
			$batchEnd = $batch + 100000;
            $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('programid', $this->programid)->groupBy('studentid')->get());
			$allBatchDropouts = Studentdropout::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('lastprogramid', $this->programid)->count();

			$batchAttrition[$batch / 100000] = round(($allBatchDropouts/$allBatchStudents)*100, 2);
		}

		return $batchAttrition;
	}

    public function getSpecificBatchAttrition($batch){ //format is year
        $batch = $batch*100000;
        $batchEnd = $batch + 100000;

        $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('programid', $this->programid)->groupBy('studentid')->get());
        $allBatchDropouts = Studentdropout::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('lastprogramid', $this->programid)->count();

        if($allBatchStudents === 0){
            $batchAttrition = -1; //no students of this batch for this program
        }
        else{
            $batchAttrition = round(($allBatchDropouts/$allBatchStudents)*100, 2);
        }
        return $batchAttrition;
    }

    //Get total average shift rate
	public function getAveShiftRate() {
        //To get batches of program whithin 2000-2009 + max(2011 for the case of applied physics)
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        if($this->revisionyear > 2009){
            $max = 2012;
        }
        else{
            if($this->programid === 28){
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

		$batchShifts = $this->getBatchShiftRate();
        $sumShiftRate = 0;
		foreach ($batches as $batch) {
			$sumShiftRate = $sumShiftRate +  ($batchShifts[$batch / 100000]/100);
		}

		$aveShiftRate = round(($sumShiftRate / (count($batches))) * 100, 2);
		return $aveShiftRate;
	}

	//Get batch shift rate
    //Ex. Get students from batch 20000 who shifted out
	public function getBatchShiftRate() {
		$batchShiftRate = [];
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        if($this->revisionyear > 2009){
            $max = 2012;
        }
        else{
            if($this->programid === 28){
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

		foreach ($batches as $batch) {
			$batchEnd = $batch + 100000;
            $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('programid', $this->programid)->groupBy('studentid')->get());

            if($this->programid === 28){
                $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->groupBy('studentid')->get());
                $domShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->groupBy('studentid')->get());
                $allBatchShiftees = $allBatchShiftees + $domShiftees;
            }
            else{
                $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->groupBy('studentid')->get());
            }

			$batchShiftRate[$batch / 100000] = round(($allBatchShiftees/$allBatchStudents)*100, 2);
		}

		return $batchShiftRate;
	}

    public function getSpecificBatchShiftRate($batch){//format of batch is year ex. 2012
        $batch = $batch*100000;
        $batchEnd = $batch + 100000;

        $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('programid', $this->programid)->groupBy('studentid')->get());

        if($this->programid === 28){
            $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->groupBy('studentid')->get());
            $domShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->groupBy('studentid')->get());
            $allBatchShiftees = $allBatchShiftees + $domShiftees;
        }
        else{
            $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->groupBy('studentid')->get());
        }

        if($allBatchStudents === 0){
            $batchShiftRate = -1; //no students of this batch for this program
        }
        else{
            $batchShiftRate = round(($allBatchShiftees/$allBatchStudents)*100, 2);
        }
        return $batchShiftRate;
    }

    public function getDivision(){
        $division = [];

        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
        if($this->revisionyear > 2009){
            $max = 2012;
        }
        else{
            if($this->programid === 28){
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

        $allStudents = count(Studentterm::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('programid', $this->programid)->groupBy('studentid')->get());
        $allDropouts = Studentdropout::where('lastprogramid', $this->programid)->where('studentid', '>', $min)->where('studentid', '<', $max)->count();

        if($this->programid === 28){
            $allShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->groupBy('studentid')->get());
            $domShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->groupBy('studentid')->get());
            $allShiftees = $allShiftees + $domShiftees;
            $normal = $allStudents - ($allDropouts + $allShiftees);
        }
        else{
            $allShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->groupBy('studentid')->get());
            $normal = $allStudents - ($allDropouts + $allShiftees);
        }

        $dropRate = round(($allDropouts/$allStudents)*100, 2);
        $shiftRate = round(($allShiftees/$allStudents)*100, 2);
        $normalRate = round(($normal/$allStudents)*100, 2);

        $division['Dropout Rate'] = $dropRate;
        $division['Shift Rate'] = $shiftRate;
        $division['Retention Rate'] = $normalRate;

        return $division;
    }

    public function getNumYears(){
        if($this->programid === 28){
            return 4;
        }
        else{
            return $this->numyears;
        }
    }


}
