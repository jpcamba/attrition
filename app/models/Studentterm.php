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

    //Get number of years per student
    public static function getNumberOfYears() {
        return Studentterm::join('programs', 'programs.programid', '=', 'studentterms.programid')->select(DB::raw('COUNT(*)/3 as numYears'))->where('programs.degreelevel', 'U')->whereNotIn('programs.programid', array(62, 66, 38, 22))->groupBy('studentid')->get();
    }

    //Get count of all students
    public static function getTotalStudentsCount() {
        return Studentterm::select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>=', 200000000)->where('studentterms.studentid', '<', 201000000)->count();
    }

    //Get count of batch students
    public static function getBatchStudents($batch) {
        $batchEnd = $batch + 100000;
        return Studentterm::select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>=', $batch)->where('studentterms.studentid', '<', $batchEnd)->groupBy('studentterms.studentid')->orderBy('studentterms.studentid')->get();
    }

    //Get count of batch students
    public static function getBatchStudentsCount($batch) {
        $batchEnd = $batch + 100000;
        return Studentterm::select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>=', $batch)->where('studentterms.studentid', '<', $batchEnd)->count();
    }

    //Get employment of student
    public static function getOneEmployment($studentId) {
        return Studentterm::select('employment')->where('studentid', $studentId)->get();
    }

    //Get average grade of student
    public static function getOneGrades($studentId) {
        return Studentterm::select('gwa')->where('studentid', $studentId)->avg('gwa');
    }

    //Get stbracket of student
    public static function getOneStbracket($studentId) {
        return Studentterm::select('stfapbracket')->where('studentid', $studentId)->get();
    }

    /*public static function getByPrimaryKeys($studentid, $aysem, $programid) {
        return Widget::where('studentid', '=', $studentid)
            ->where('aysem', '=', $aysem)
            ->where('programid', '=', $programid)
            ->first();
    }*/
}