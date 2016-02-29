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
            $studentCount = $year->getAveProgramStudents($this->programid);
            if($studentCount === 0){
                $zeroStudents++;
            }
            $numberOfStudents = $numberOfStudents + $studentCount;
        }
        return $totalAve = $numberOfStudents/(count($years)-$zeroStudents);
    }


}