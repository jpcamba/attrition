<?php


class Student extends Eloquent {

    protected $table = 'students';
    protected $primaryKey = 'studentid';

    public function studentterms(){
        return $this->hasMany('Studentterm', 'studentid');
    }

    public function studentshifts(){
        return $this->hasMany('Studentshift', 'studentid');
    }

    public function studentdropout(){
        return $this->hasOne('Studentdropout', 'studentid');
    }

    public function getYearsinUniv(){
        $records = $this->studentterms()->count();
        $years = ($records)/3;
        return $years;
    }


}
