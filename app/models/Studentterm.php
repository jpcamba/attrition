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

    //Get total students
    public function scopeGetTotalStudents($query) {
        return $query->select('studentid')->groupBy('studentid')->orderBy('studentid')->get();
    }

    //Get batch students
    public function scopeGetBatchStudents($query, $batch) {
        $batchEnd = $batch + 100000;
        return $query->select('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->groupBy('studentid')->orderBy('studentid')->get();
    }

    /*public static function getByPrimaryKeys($studentid, $aysem, $programid) {
        return Widget::where('studentid', '=', $studentid)
            ->where('aysem', '=', $aysem)
            ->where('programid', '=', $programid)
            ->first();
    }*/
}
