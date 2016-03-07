<?php

class Program extends Eloquent {

    protected $table = 'programs';
    protected $primaryKey = 'programid';

    public function studentterms(){
        return $this->hasMany('Studentterm', 'programid');
    }

    public function colleges(){
        return $this->belongsTo('College', 'unitid');
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
        $studentsSem1 = $this->studentterms()->where('aysem', strval($year).'1' )->count();
        $studentsSem2 = $this->studentterms()->where('aysem', strval($year).'2' )->count();

        $aveStudents = ($studentsSem1 + $studentsSem2)/2;
        return $aveStudents;
    }

    public function getYearlySemDifference($year){
        $studentsSem1 = $this->studentterms()->where('aysem', strval($year).'1' )->count();
        $studentsSem2 = $this->studentterms()->where('aysem', strval($year).'2' )->count();

        $semDifference = $studentsSem1 - $studentsSem2;
        return $semDifference;
    }


}
