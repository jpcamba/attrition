<?php

class Studentdropout extends Eloquent {

    protected $table = 'studentdropouts';
    protected $primaryKey = 'id';

    public function studentterms() {
        return $this->hasMany('Studentterm', 'studentid');
    }

    public function programs() {
        return $this->belongsTo('Program', 'programid');
    }

}
