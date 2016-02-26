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
        //echo "Unit name: " + $this->unitname + " Count: " + $count + "<br/>";
        return $count;
    }

}
