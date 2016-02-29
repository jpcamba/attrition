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

        $count = $this->studentterms()->count();
        return $count;
    }

}
