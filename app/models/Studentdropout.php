<?php

class Studentdropout extends Eloquent {

    protected $table = 'studentdropouts';
    protected $primaryKey = 'id';

    public function studentterms() {
        return $this->belongsTo('Studentterm', 'studentid');
    }

    public function programs() {
        return $this->belongsTo('Program', 'programid');
    }

    public function students() {
        return $this->belongsTo('Student', 'studentid');
    }

    //Get total dropouts
    /*public function scopeGetTotalDropouts($query) {
    	return $query->select('studentid')->get();
    }*/

    //Get batch students
    public function scopeGetBatchDropouts($query, $batch) {
        $batchEnd = $batch + 100000;
        return $query->select('studentid')->groupBy('studentid')->orderBy('studentid')->where('studentid', '>', $batch)->where('studentid', '<', $batchEnd)->get();
    }
}
