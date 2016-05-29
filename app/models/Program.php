<?php

class Program extends Eloquent {

    protected $table = 'programs';
    protected $primaryKey = 'programid';

    public $timestamps = false;

    public function studentterms(){
        return $this->hasMany('Studentterm', 'programid');
    }

    public function department(){
        return $this->belongsTo('Department', 'unitid');
    }

    //remove outliers - from internet
    function remove_outliers($dataset, $magnitude = 1) {
      $count = count($dataset);
      $mean = array_sum($dataset) / $count; // Calculate the mean
      $deviation = sqrt(array_sum(array_map(array($this, 'sd_square'), $dataset, array_fill(0, $count, $mean))) / $count) * $magnitude; // Calculate standard deviation and times by magnitude

      return array_filter($dataset, function($x) use ($mean, $deviation) { return ($x <= $mean + $deviation && $x >= $mean - $deviation); }); // Return filtered array of values that lie within $mean +- $deviation.
    }

    public function sd_square($x, $mean) {
      return pow($x - $mean, 2);
    }

    public function getAveStudents(){
        $years = Studentterm::where('programid', $this->programid)->where('year', '>', 1999)->where('year', '<', 2014)->groupBy('year')->orderBy('year', 'asc')->lists('year');

        $allYearsAve = [];
        foreach($years as $year){
            array_push($allYearsAve,  $this->getYearlyAveStudents($year));
        }

        $filteredYearsAve = $this->remove_outliers($allYearsAve, 1);

        $sumAve = 0;
        foreach($filteredYearsAve as $yearAve){
            $sumAve = $sumAve + $yearAve;
        }
        $totalAve = $sumAve/(count($filteredYearsAve));

        return round($totalAve, 2);

        /*$numberOfStudents = 0;
        $zeroStudents = 0;
        foreach($years as $year){
            $studentCount = $this->getYearlyAveStudents($year);
            if($studentCount == 0){
                $zeroStudents++;
            }
            $numberOfStudents = $numberOfStudents + $studentCount;
        }
        $totalAve = $numberOfStudents/(count($years)-$zeroStudents);

        return round($totalAve, 2);*/
    }

    public function getYearlyAveStudents($year){

        $studentsSem1 = $this->studentterms()->where('aysem', strval($year).'1' )->count();
        $studentsSem2 = $this->studentterms()->where('aysem', strval($year).'2' )->count();

        if($this->programid == 28){
            $domProgram = Program::where('programid', 38)->first();
            $domSem1 = $domProgram->studentterms()->whereIn('yearlevel', array(3,4))->where('aysem', strval($year).'1' )->count();
            $domSem2 = $domProgram->studentterms()->whereIn('yearlevel', array(3,4))->where('aysem', strval($year).'2' )->count();

            $studentsSem1 = $studentsSem1 + $domSem1;
            $studentsSem2 = $studentsSem2 + $domSem2;
        }

        $aveStudents = ($studentsSem1 + $studentsSem2)/2;
        return $aveStudents;
    }

    public function getYearlySemDifference($year){

        $studentsSem1 = $this->studentterms()->where('aysem', strval($year).'1' )->count();
        $studentsSem2 = $this->studentterms()->where('aysem', strval($year).'2' )->count();

        if($this->programid == 28){
            $domProgram = Program::where('programid', 38)->first();
            $domSem1 = $domProgram->studentterms()->whereIn('yearlevel', array(3,4))->where('aysem', strval($year).'1' )->count();
            $domSem2 = $domProgram->studentterms()->whereIn('yearlevel', array(3,4))->where('aysem', strval($year).'2' )->count();

            $studentsSem1 = $studentsSem1 + $domSem1;
            $studentsSem2 = $studentsSem2 + $domSem2;
        }

        $semDifference = $studentsSem2 - $studentsSem1;
        return $semDifference;
    }

    public function getAveYearsOfStay(){
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
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

        //Get list of dropouts. Remove them from computation.
        $dropouts = DB::table('studentdropouts')->lists('studentid');

        //Get list of students from shift table whose progam 1 is this program and whose program1years are less than numyears of program. place their studentids in an array. Exclude them from computation.
        if($this->programid == 28){
            $shiftees = DB::table('studentshifts')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', '=', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->lists('studentid');
            $domShiftees = DB::table('studentshifts')->where('studentid', '>', $min)->where('studentid', '<', $max)->whereNotIn('studentid', $dropouts)->where('program1id', '=', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->lists('studentid');

            foreach($domShiftees as $domShiftee) {
                array_push($shiftees, $domShiftee);
            }
        }
        else{
            $shiftees = DB::table('studentshifts')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', '=', $this->programid)->where('program1years', '<', $this->numyears)->lists('studentid');
        }

        if($this->programid == 28){
            $studentids = DB::table('studentterms')->select('studentid')->where('programid', $this->programid)->where('studentid', '>', $min)->where('studentid', '<', $max)->whereNotIn('studentid', $dropouts)->whereNotIn('studentid', $shiftees)->groupBy('studentid')->lists('studentid');

            $totalYears = 0;
            foreach($studentids as $studentid){
                //check if student shifted to Doctor of Medicine
                //if he shifted to DoM and if his number of years in (intarmed + DoM) is greater than 4 then let his stay be 4
                //else get his real years of stay
                $dom = Studentshift::where('studentid', $studentid)->where('program1id', 28)->where('program2id', 38)->first();

                if($dom != NULL){ //if record exists
                    if($dom->program2years >= 2){
                        $domYears = 2;
                    }
                    if($dom->program1years == 1){  //Some students shift to DoM after 1 year of Intarmed
                        if($dom->program2years >= 3){
                            $domYears = 3;
                        }
                    }
                    $numYears = $dom->program1years + $domYears;

                }
                else{
                    $numYears = (DB::table('studentterms')->where('studentid', $studentid)->where('programid', $this->programid)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->count())/2;
                }
                $totalYears = $totalYears + $numYears;
            }
            $aveYearsOfStay = round($totalYears/count($studentids), 2);
        }
        else{
            $numberOfYearsPerStudent = DB::table('studentterms')->select(DB::raw('COUNT(*)/2 as numYears'))->where('programid', $this->programid)->where('studentid', '>', $min)->where('studentid', '<', $max)->whereNotIn('studentid', $dropouts)->whereNotIn('studentid', $shiftees)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->groupBy('studentid')->get();

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

        $dropouts = DB::table('studentdropouts')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('lastprogramid', $this->programid)->lists('studentid');

        if($this->programid == 28){
            $shiftees = DB::table('studentshifts')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', '=', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->get();
            //$domShiftees = DB::table('studentshifts')->where('studentid', '>', $min)->where('studentid', '<', $max)->whereNotIn('studentid', $dropouts)->where('program1id', '=', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->get();

            //foreach($domShiftees as $domShiftee) {
            //    array_push($shiftees, $domShiftee);
            //}
        }
        else{
            $shiftees = DB::table('studentshifts')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', '=', $this->programid)->where('program1years', '<', $this->numyears)->whereNotIn('studentid', $dropouts)->get();
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
        $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');


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

        $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');

		foreach ($batches as $batch) {
			$batchEnd = $batch + 100000;
            $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('programid', $this->programid)->groupBy('studentid')->get());
			$allBatchDropouts = Studentdropout::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('lastprogramid', $this->programid)->count();
            $allBatchDelayed = Studentdelayed::getBatchDelayedCountProgram($batch, $this->programid);

            if($this->programid == 28){
                $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->get());
            }
            else{
                $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->where('program2id', '!=', 38)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->get());
            }

			$batchAttrition[$batch / 100000] = round((($allBatchDropouts + $allBatchShiftees + $allBatchDelayed)/$allBatchStudents)*100, 2);
		}

		return $batchAttrition;
	}

    public function getSpecificBatchAttrition($batch){ //format is year

        $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');

        $batch = $batch*100000;
        $batchEnd = $batch + 100000;

        $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('programid', $this->programid)->groupBy('studentid')->get());
        $allBatchDropouts = Studentdropout::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('lastprogramid', $this->programid)->count();

        if($this->programid == 28){
            $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->get());
        }
        else{
            $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->where('program2id', '!=', 38)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->get());
        }

        if($allBatchStudents == 0){
            $batchAttrition = -1; //no students of this batch for this program
        }
        else{
            $batchAttrition =  round((($allBatchDropouts + $allBatchShiftees)/$allBatchStudents)*100, 2);
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

        $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');

		foreach ($batches as $batch) {
			$batchEnd = $batch + 100000;
            $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('programid', $this->programid)->groupBy('studentid')->get());

            if($this->programid == 28){
                $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->get());
            }
            else{
                $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->where('program2id', '!=', 38)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->get());
            }

			$batchShiftRate[$batch / 100000] = round(($allBatchShiftees/$allBatchStudents)*100, 2);
		}

		return $batchShiftRate;
	}

    public function getAveDelayedRate(){
        $sumDelayed = 0;

        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
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

        $batchDelayed = $this->getBatchDelayedRate();

        foreach ($batches as $batch) {
            $sumDelayed = $sumDelayed + $batchDelayed[$batch / 100000];
        }

        $aveDelayed = round($sumDelayed / count($batches), 2);
        return $aveDelayed;
    }

    public function getBatchDelayedRate(){
        $batchDelayedRate = [];

        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
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

        foreach ($batches as $batch) {
            $batchEnd = $batch + 100000;
            $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('programid', $this->programid)->groupBy('studentid')->get());
            $allBatchDelayed = Studentdelayed::getBatchDelayedCountProgram($batch, $this->programid);
            $batchDelayedRate[$batch / 100000] = round(($allBatchDelayed / $allBatchStudents) * 100, 2);
        }

        return $batchDelayedRate;
    }

    public function getAveDropoutRate(){
        $sumDropout = 0;

        ///To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
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

        $batchDropout = $this->getBatchDropoutRate();

        foreach ($batches as $batch) {
            $sumDropout = $sumDropout + $batchDropout[$batch / 100000];
        }

        $aveDropout = round($sumDropout / count($batches), 2);
        return $aveDropout;
    }

    public function getBatchDropoutRate(){
        $batchDropoutRate = [];
        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
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

        foreach ($batches as $batch) {
            $batchEnd = $batch + 100000;

            $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('programid', $this->programid)->groupBy('studentid')->get());
            $allBatchDropouts = Studentdropout::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('lastprogramid', $this->programid)->count();

            $batchDropoutRate[$batch / 100000] = round(($allBatchDropouts / $allBatchStudents) * 100, 2);
        }

        return $batchDropoutRate;
    }

    public function getSpecificBatchShiftRate($batch){//format of batch is year ex. 2012
        $batch = $batch*100000;
        $batchEnd = $batch + 100000;

        $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('programid', $this->programid)->groupBy('studentid')->get());

        $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');

        if($this->programid == 28){
            $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->get());
            //$domShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->groupBy('studentid')->get());
            //$allBatchShiftees = $allBatchShiftees + $domShiftees;
        }
        else{
            $allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->get());
        }

        if($allBatchStudents == 0){
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

        $allStudents = count(Studentterm::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('programid', $this->programid)->groupBy('studentid')->get());
        $allDropouts = Studentdropout::where('lastprogramid', $this->programid)->where('studentid', '>', $min)->where('studentid', '<', $max)->count();

        $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');

        if($this->programid == 28){
            $allShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->get());
            //$domShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->groupBy('studentid')->get());
            //$allShiftees = $allShiftees + $domShiftees;
            $normal = $allStudents - ($allDropouts + $allShiftees);
        }
        else{
            $allShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->whereNotIn('studentid', $dropouts)->where('program2id', '!=', 38)->groupBy('studentid')->get());
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
        if($this->programid == 28){
            return 4;
        }
        else{
            return $this->numyears;
        }
    }

    public function getEmploymentCount(){
        $employmentArray = [];
        $programDropouts = Studentdropout::where('lastprogramid', $this->programid)->get();
        $dropoutCount = count($programDropouts);
        $employed = 0;
        $unemployed = 0;

        foreach($programDropouts as $dropout){
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
        $programDropouts = Studentdropout::where('lastprogramid', $this->programid)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $dropoutCount = count($programDropouts);
        $employed = 0;
        $unemployed = 0;

        foreach($programDropouts as $dropout){
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
        $programDropouts = Studentdropout::where('lastprogramid', $this->programid)->get();
        $dropoutCount = count($programDropouts);
        $passed = 0;
        $failed = 0;

        foreach($programDropouts as $dropout){
            $aveGWA = Studentterm::select('gwa')->where('studentid', $dropout->studentid)->where('programid', $this->programid)->where('gwa', '>', 0)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->avg('gwa');

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
        $programDropouts = Studentdropout::where('lastprogramid', $this->programid)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $dropoutCount = count($programDropouts);
        $passed = 0;
        $failed = 0;

        foreach($programDropouts as $dropout){
            $aveGWA = Studentterm::select('gwa')->where('studentid', $dropout->studentid)->where('programid', $this->programid)->where('gwa', '>', 0)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->avg('gwa');

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
        $programDropouts = Studentdropout::where('lastprogramid', $this->programid)->get();
        $bracketA = 0;
        $bracketB = 0;
        $bracketC = 0;
        $bracketD = 0;
        $bracketE1 = 0;
        $bracketE2 = 0;
        $unstated = 0;

        foreach($programDropouts as $dropout){
            $results = Studentterm::select('stfapbracket')->where('studentid', $dropout->studentid)->where('programid', $this->programid)->groupBy('stfapbracket')->lists('stfapbracket');
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
                }
            }
        }

        $tagged = $bracketA + $bracketB + $bracketC + $bracketD + $bracketE1 + $bracketE2;

        $bracketArray["A"] = round(($bracketA/$tagged)*100, 2);
        $bracketArray["B"] = round(($bracketB/$tagged)*100, 2);
        $bracketArray["C"] = round(($bracketC/$tagged)*100, 2);
        $bracketArray["D"] = round(($bracketD/$tagged)*100, 2);
        $bracketArray["E1"] = round(($bracketE1/$tagged)*100, 2);
        $bracketArray["E2"] = round(($bracketE2/$tagged)*100, 2);
        return $bracketArray;
    }

    public function getSpecificBatchSTBracketCount($batch){
        $batch = $batch*100000;
        $batchEnd = $batch + 100000;

        $bracketArray = [];
        $programDropouts = Studentdropout::where('lastprogramid', $this->programid)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $bracketA = 0;
        $bracketB = 0;
        $bracketC = 0;
        $bracketD = 0;
        $bracketE1 = 0;
        $bracketE2 = 0;
        $unstated = 0;

        foreach($programDropouts as $dropout){
            $results = Studentterm::select('stfapbracket')->where('studentid', $dropout->studentid)->where('programid', $this->programid)->groupBy('stfapbracket')->lists('stfapbracket');
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
                }
            }
        }

        $tagged = $bracketA + $bracketB + $bracketC + $bracketD + $bracketE1 + $bracketE2;

        $bracketArray["A"] = round(($bracketA/$tagged)*100, 2);
        $bracketArray["B"] = round(($bracketB/$tagged)*100, 2);
        $bracketArray["C"] = round(($bracketC/$tagged)*100, 2);
        $bracketArray["D"] = round(($bracketD/$tagged)*100, 2);
        $bracketArray["E1"] = round(($bracketE1/$tagged)*100, 2);
        $bracketArray["E2"] = round(($bracketE2/$tagged)*100, 2);
        return $bracketArray;
    }

    public function getRegionCount(){
        $regionArray = [];
        $programDropouts = Studentdropout::where('lastprogramid', $this->programid)->get();
        $luzon = 0;
        $visayas = 0;
        $mindanao = 0;
        $unstated = 0;

        $luzonRegions = ['NCR', 'I', 'CAR', 'II', 'III', 'IV', 'V'];
        $visayasRegions = ['VI', 'VII', 'VIII'];
        $mindanaoRegions = ['IX', 'X', 'XI', 'XII', 'XIII', 'ARMM'];

        foreach($programDropouts as $dropout){
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
        $programDropouts = Studentdropout::where('lastprogramid', $this->programid)->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
        $luzon = 0;
        $visayas = 0;
        $mindanao = 0;
        $unstated = 0;

        $luzonRegions = ['NCR', 'I', 'CAR', 'II', 'III', 'IV', 'V'];
        $visayasRegions = ['VI', 'VII', 'VIII'];
        $mindanaoRegions = ['IX', 'X', 'XI', 'XII', 'XIII', 'ARMM'];

        foreach($programDropouts as $dropout){
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
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
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

        $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');

        if($this->programid == 28){
            $programShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');
            //$domShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->groupBy('studentid')->lists('studentid');

            //foreach($domShiftees as $shiftee){
            //    array_push($programShiftees, $shiftee);
            //}

        }
        else{
            $programShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');
        }

        $programShiftees = array_unique($programShiftees);
        $shifteeCount = count($programShiftees);
        $passed = 0;
        $failed = 0;

        foreach($programShiftees as $shifteeid){
            $aveGWA = Studentterm::select('gwa')->where('studentid', $shifteeid)->where('programid', $this->programid)->where('gwa', '>', 0)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->avg('gwa');

            if($aveGWA > 3.00){
                $failed++;
            }
        }

        if($shifteeCount != 0){
            $passed = $shifteeCount - $failed;
            $gradeArray['1.00 - 3.00'] = round(($passed/$shifteeCount)*100, 2);
            $gradeArray['Below 3.00'] = round(($failed/$shifteeCount)*100, 2);
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

        $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');

        if($this->programid == 28){
            $programShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');
            //$domShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->groupBy('studentid')->lists('studentid');
            //foreach($domShiftees as $shiftee){
            //    array_push($programShiftees, $shiftee);
            //}

        }
        else{
            $programShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');
        }

        $programShiftees = array_unique($programShiftees);
        $shifteeCount = count($programShiftees);
        $passed = 0;
        $failed = 0;

        foreach($programShiftees as $shifteeid){
            $aveGWA = Studentterm::select('gwa')->where('studentid', $shifteeid)->where('programid', $this->programid)->where('gwa', '>', 0)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->avg('gwa');

            if($aveGWA > 3.00){
                $failed++;
            }
        }

        if($shifteeCount != 0){
            $passed = $shifteeCount - $failed;
            $gradeArray['1.00 - 3.00'] = round(($passed/$shifteeCount)*100, 2);
            $gradeArray['Below 3.00'] = round(($failed/$shifteeCount)*100, 2);
        }
        else{
            $gradeArray['No Shiftees'] = 0;;
        }

        return $gradeArray;
    }

    public function getShiftSTBracketCount(){
        $bracketArray = [];

        //To get batches of program whithin 2000-2009
        $progYears = Studentterm::where('programid', $this->programid)->groupBy('year')->orderBy('year', 'asc')->lists('year');
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

        $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');

        if($this->programid == 28){
            $programShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');
            //$domShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->groupBy('studentid')->lists('studentid');
            //foreach($domShiftees as $shiftee){
            //    array_push($programShiftees, $shiftee);
            //}

        }
        else{
            $programShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)->whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');
        }

        $programShiftees = array_unique($programShiftees);
        $shifteeCount = count($programShiftees);

        $bracketA = 0;
        $bracketB = 0;
        $bracketC = 0;
        $bracketD = 0;
        $bracketE1 = 0;
        $bracketE2 = 0;
        $unstated = 0;

        foreach($programShiftees as $shiftee){
            $results = Studentterm::select('stfapbracket')->where('studentid', $shiftee)->where('programid', $this->programid)->groupBy('stfapbracket')->lists('stfapbracket');
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
                }
            }
        }

        if($shifteeCount != 0){
            $tagged = $bracketA + $bracketB + $bracketC + $bracketD + $bracketE1 + $bracketE2;

            $bracketArray["A"] = round(($bracketA/$tagged)*100, 2);
            $bracketArray["B"] = round(($bracketB/$tagged)*100, 2);
            $bracketArray["C"] = round(($bracketC/$tagged)*100, 2);
            $bracketArray["D"] = round(($bracketD/$tagged)*100, 2);
            $bracketArray["E1"] = round(($bracketE1/$tagged)*100, 2);
            $bracketArray["E2"] = round(($bracketE2/$tagged)*100, 2);
        }
        else{
            $bracketArray["No Shiftees"] = 0;
        }

        return $bracketArray;
    }

    public function getShiftSpecificBatchSTBracketCount($batch){
        $min = $batch*100000;
        $max = $batch + 100000;

        $bracketArray = [];

        $dropouts = DB::table('studentdropouts')->where('lastprogramid', $this->programid)->lists('studentid');

        if($this->programid == 28){
            $programShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '!=', 38)->where('program1years', '<=', $this->numyears)>whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');
            //$domShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program2id', '=', 38)->where(DB::raw('program1years + program2years'), '<', 4)->groupBy('studentid')->lists('studentid');
            //foreach($domShiftees as $shiftee){
            //    array_push($programShiftees, $shiftee);
            //}

        }
        else{
            $programShiftees = Studentshift::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->where('program1id', $this->programid)->where('program1years', '<', $this->numyears)>whereNotIn('studentid', $dropouts)->groupBy('studentid')->lists('studentid');
        }

        $programShiftees = array_unique($programShiftees);
        $shifteeCount = count($programShiftees);

        $bracketA = 0;
        $bracketB = 0;
        $bracketC = 0;
        $bracketD = 0;
        $bracketE1 = 0;
        $bracketE2 = 0;
        $unstated = 0;

        foreach($programShiftees as $shiftee){
            $results = Studentterm::select('stfapbracket')->where('studentid', $shiftee)->where('programid', $this->programid)->groupBy('stfapbracket')->lists('stfapbracket');
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
                }
            }
        }

        if($shifteeCount != 0){
            $tagged = $bracketA + $bracketB + $bracketC + $bracketD + $bracketE1 + $bracketE2;

            $bracketArray["A"] = round(($bracketA/$tagged)*100, 2);
            $bracketArray["B"] = round(($bracketB/$tagged)*100, 2);
            $bracketArray["C"] = round(($bracketC/$tagged)*100, 2);
            $bracketArray["D"] = round(($bracketD/$tagged)*100, 2);
            $bracketArray["E1"] = round(($bracketE1/$tagged)*100, 2);
            $bracketArray["E2"] = round(($bracketE2/$tagged)*100, 2);
        }
        else{
            $bracketArray["No Shiftees"] = 0;
        }

        return $bracketArray;
    }


}
