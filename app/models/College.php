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

        $semDifference = $studentsSem1 - $studentsSem2;
        return $semDifference;
    }

}
