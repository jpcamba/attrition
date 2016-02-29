<?php

class Studentterm extends Eloquent {
    protected $table = 'studentterms';

    public function student(){
        return $this->belongsTo('Student', 'studentid');
    }

    public function year(){
        return $this->belongsTo('Year', 'year');
    }

    public function program(){
        return $this->belongsTo('Program', 'programid');
    }

    public function studentdropouts() {
        return $this->hasOne('Studentdropout', 'studentid');
    }

    /*public static function getByPrimaryKeys($studentid, $aysem, $programid) {
        return Widget::where('studentid', '=', $studentid)
            ->where('aysem', '=', $aysem)
            ->where('programid', '=', $programid)
            ->first();
    }*/
}
