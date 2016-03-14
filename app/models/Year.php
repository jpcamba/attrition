<?php

class Year extends Eloquent {

    protected $table = 'years';
    protected $primaryKey = 'year';

    public function studentterms(){
        return $this->hasMany('Studentterm', 'year');
    }

    public function countSem1Students(){
        return $this->studentsSem1Count = $this->studentterms()->where('aysem', strval($this->year).'1' )
        ->whereHas('program', function($q){
            $q->whereNotIn('programid', array(62, 66, 38, 22));
            $q->where('degreelevel', 'U');
        })->count();
    }

    public function countSem2Students(){
        return $this->studentsSem1Count = $this->studentterms()->where('aysem', strval($this->year).'2' )
        ->whereHas('program', function($q){
            $q->whereNotIn('programid', array(62, 66, 38, 22));
            $q->where('degreelevel', 'U');
        })->count();
    }

    public function getAveStudents() {
        $studentsSem1 = $this->countSem1Students();
        $studentsSem2 = $this->countSem2Students();

        $aveStudents = ($studentsSem1 + $studentsSem2)/2;
        return $aveStudents;
    }

    public function getSemDifference() {
        $studentsSem1 = $this->countSem1Students();
        $studentsSem2 = $this->countSem2Students();

        $semDifference = $studentsSem2 - $studentsSem1;
        return $semDifference;
    }

}
