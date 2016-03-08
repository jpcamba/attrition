<?php


class Department extends Eloquent {

    protected $table = 'units';
    protected $primaryKey = 'unitid';

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
        return $totalDepartmentAve;
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

        $semDifference = $studentsSem1 - $studentsSem2;
        return $semDifference;
    }

}
