<?php


class Student extends Eloquent {

    protected $table = 'students';
    protected $primaryKey = 'studentid';

    public function studentterms()
    {
        return $this->hasMany('Studentterm');
    }

}
