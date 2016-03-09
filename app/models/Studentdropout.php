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
    
    //Get total students
    public static function getTotalDropoutsCount() {
        return Studentdropout::select('studentid')->count();
    }

    //Get batch students
    public static function getBatchDropouts($batch) {
        $batchEnd = $batch + 100000;
        return Studentdropout::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->groupBy('studentid')->orderBy('studentid')->get();
    }

    //Get count of batch students
    public static function getBatchDropoutsCount($batch) {
        $batchEnd = $batch + 100000;
        return Studentdropout::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->count();
    }
}
