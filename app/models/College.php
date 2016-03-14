<?php


class College extends Eloquent {

    protected $table = 'units';
    protected $primaryKey = 'unitid';

    public $studentsSem1Count = 0;
    public $studentsSem2Count = 0;

    public function departments(){
        return $this->hasMany('Department', 'parentunitid');
    }

    public function programs()
    {
        return $this->hasManyThrough('Program', 'Department', 'parentunitid', 'unitid');
    }

    public function getAveStudents(){
        $years = Year::all();
        $departments = $this->departments()->whereHas('programs', function($q){
							$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->get();
        //$programs = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->get();
        $sumDepartmentsAve = 0;
        $sumCollegeAve = 0;
        foreach($years as $year){
            foreach($departments as $department){
                $currentDepartmentAve = $department->getYearlyAveStudents($year->year);
                $sumDepartmentsAve = $sumDepartmentsAve + $currentDepartmentAve;
            }
            $currentYearAve = $sumDepartmentsAve/(count($departments));
            $sumCollegeAve = $sumCollegeAve + $currentYearAve;
            $sumDepartmentsAve = 0;
        }
        $totalCollegeAve = $sumCollegeAve/(count($years));
        return $totalCollegeAve;
    }

    public function getYearlyAveStudents($year){
        $departments = $this->departments()->whereHas('programs', function($q){
							$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->get();

        $sumDepartmentsAve = 0;
        foreach($departments as $department){
            $currentDepartmentAve = $department->getYearlyAveStudents($year);
            $sumDepartmentsAve = $sumDepartmentsAve + $currentDepartmentAve;
        }
        $totalAve = $sumDepartmentsAve/(count($departments));
        return $totalAve;

    /*    $studentsSem1 = 0;
        $studentsSem2 = 0;
        foreach($departments as $department){
            $deptStudentsSem1 = $department->studentterms()->where('aysem', strval($year).'1' )
            ->whereHas('program', function($q){
                $q->whereNotIn('programid', array(62, 66, 38, 22));
                $q->where('degreelevel', 'U');
            })->count();
            $studentsSem1 = $studentsSem1 + $deptStudentsSem1;

            $deptStudentsSem2 = $department->studentterms()->where('aysem', strval($year).'2' )
            ->whereHas('program', function($q){
                $q->whereNotIn('programid', array(62, 66, 38, 22));
                $q->where('degreelevel', 'U');
            })->count();
            $studentsSem2 = $studentsSem2 + $deptStudentsSem2;
        }

        $aveStudents = ($studentsSem1 + $studentsSem2)/2;
        return $aveStudents;*/
    }

    public function getYearlySemDifference($year){
        $departments = $this->departments()->whereHas('programs', function($q){
							$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->get();

        $studentsSem1 = 0;
        $studentsSem2 = 0;
        foreach($departments as $department){
            $deptStudentsSem1 = $department->studentterms()->where('aysem', strval($year).'1' )
            ->whereHas('program', function($q){
                $q->whereNotIn('programid', array(62, 66, 38, 22));
                $q->where('degreelevel', 'U');
            })->count();
            $studentsSem1 = $studentsSem1 + $deptStudentsSem1;

            $deptStudentsSem2 = $department->studentterms()->where('aysem', strval($year).'2' )
            ->whereHas('program', function($q){
                $q->whereNotIn('programid', array(62, 66, 38, 22));
                $q->where('degreelevel', 'U');
            })->count();
            $studentsSem2 = $studentsSem2 + $deptStudentsSem2;
        }

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

        $programids = $this->programs()->whereNotIn('programid', array(62, 66, 22))->where('degreelevel', 'U')->lists('programid'); //include programid = 38 (doctor of medicine)

        foreach ($batches as $batch) {
            $batchEnd = $batch + 100000;
            $allBatchStudents = count(Studentterm::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->whereIn('programid', $programids)->groupBy('studentid')->get());
            $allBatchShiftees = count(DB::table('studentshifts')->join('programs', 'program1id', '=', 'programid')->select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->whereIn('program1id', $programids)->whereNotIn('program2id',  $programids)->whereRaw('program1years < CAST(numyears AS numeric)')->groupBy('studentid')->get());
			//$allBatchShiftees = count(Studentshift::select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->whereIn('program1id', $programids)->whereNotIn('program2id',  $programids)->groupBy('studentid')->get());

            if($allBatchStudents != 0){
                $batchShiftRate[$batch / 100000] = round(($allBatchShiftees / $allBatchStudents) * 100, 2);
            }
            else{
                $batchShiftRate[$batch / 100000] = -1;
            }
		}

		return $batchShiftRate;
    }

    public function getDepartmentsAveBatchAttrition(){
        $departmentsAveAttrition = [];
        $departments = $this->departments()->whereHas('programs', function($q){
							$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->get();

        foreach($departments as $department){
            $departmentsAveAttrition[$department->unitname] = $department->getAveAttrition();
        }

        return $departmentsAveAttrition;
    }

}
