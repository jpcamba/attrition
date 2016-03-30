<?php

class Assessment extends Eloquent {
    protected $table = 'assessment';

    public function student(){
        return $this->belongsTo('Student', 'studentid');
    }

    //Get average units of student
    public static function getOneAveUnits($studentId) {
        $semesters = Assessment::select('total_units', 'aysem')->where('studentid', $studentId)->get();
        $totalUnits = 0;
        $totalSemesters = 0;

        foreach ($semesters as $semester) {
            if (substr($semester->aysem, -1) === '1' || substr($semester->aysem, -1) === '2') {
                $totalUnits = $totalUnits + $semester->total_units;
                $totalSemesters++;
            }
        }

        if ($totalSemesters > 0)
            return $totalUnits / $totalSemesters;
        else
            return -1;
    }
}