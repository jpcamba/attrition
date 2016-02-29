<?php


class College extends Eloquent {

    protected $table = 'units';
    protected $primaryKey = 'unitid';

    public function programs(){
        return $this->hasMany('Program', 'unitid');
    }

    public function studentterms()
    {
        return $this->hasManyThrough('Studentterm', 'Program', 'unitid', 'programid');
    }

    public function getAveStudents(){
        $years = Year::all();
        $programs = $this->programs()->whereNotIn('programid', array(62, 66, 38, 22))->where('degreelevel', 'U')->get();
        $sumProgramsAve = 0;
        $sumCollegeAve = 0;
        foreach($years as $year){
            foreach($programs as $program){
                $currentProgramAve =  $year->getAveProgramStudents($program->programid);
                $sumProgramsAve = $sumProgramsAve + $currentProgramAve;
            }
            $currentYearAve = $sumProgramsAve/(count($programs));
            $sumCollegeAve = $sumCollegeAve + $currentYearAve;
            $sumProgramsAve = 0;
        }
        $totalCollegeAve = $sumCollegeAve/(count($years));
        return $totalCollegeAve;
    }

    public function getYearlyAveStudents($year){
        $studentsSem1 = $this->studentterms()->where('aysem', strval($year).'1' )->whereHas('program', function($q){
    						$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->count();

        $studentsSem2 = $this->studentterms()->where('aysem', strval($year).'2' )->whereHas('program', function($q){
    						$q->whereNotIn('programid', array(62, 66, 38, 22));
    						$q->where('degreelevel', 'U');
    					})->count();

        $aveStudents = ($studentsSem1 + $studentsSem2)/2;
        return $aveStudents;
    }

    public function getYearlySemDifference($year){
        $studentsSem1 = $this->studentterms()->where('aysem', strval($year).'1' )->whereHas('program', function($q){
    						$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->count();

        $studentsSem2 = $this->studentterms()->where('aysem', strval($year).'2' )->whereHas('program', function($q){
    						$q->whereNotIn('programid', array(62, 66, 38, 22));
    						$q->where('degreelevel', 'U');
    					})->count();

        $semDifference = $studentsSem1 - $studentsSem2;
        return $semDifference;
    }

}
