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

    //Get programids that belong in department
    public static function getDeptPrograms($departmentid) {
        $programs = Program::select('programid')->where('unitid', $departmentid)->where('degreelevel', 'U')->groupBy('programid')->get();
        $programids = [];

        foreach ($programs as $program) {
            array_push($programids, $program->programid);
        }

        return $programids;
    }

    //Get programids that belong in college
    public static function getCollPrograms($collegeid) {
        $departments = Department::select('unitid')->where('parentunitid', $collegeid)->groupBy('unitid')->get();
        $departmentids = [];

        foreach ($departments as $department) {
            array_push($departmentids, $department->unitid);
        }

        $programs = Program::select('programid')->whereIn('unitid', $departmentids)->where('degreelevel', 'U')->groupBy('programid')->get();
        $programids = [];

        foreach ($programs as $program) {
            array_push($programids, $program->programid);
        }

        return $programids;
    }

    //Get number of years per student
    public static function getNumberOfYears() {
        $dropouts = DB::table('studentdropouts')->lists('studentid');

        return Studentterm::join('programs', 'programs.programid', '=', 'studentterms.programid')->select(DB::raw('COUNT(*)/3 as numYears'))->where('programs.degreelevel', 'U')->whereNotIn('programs.programid', array(62, 66, 38, 22))->whereNotIn('studentid', $dropouts)->groupBy('studentid')->where('studentterms.studentid', '>=', 200000000)->where('studentterms.studentid', '<', 201000000)->get();
    }

    //Get all students
    public static function getAllStudents() {
        return Studentterm::select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>=', 200000000)->where('studentterms.studentid', '<', 201000000)->whereNotIn('programs.programid', array(62, 66))->groupBy('studentterms.studentid')->get();
    }

    //Get count of all students
    public static function getTotalStudentsCount() {
        return Studentterm::select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>=', 200000000)->where('studentterms.studentid', '<', 201000000)->groupBy('studentterms.studentid')->count();
    }

    //Get batch students
    public static function getBatchStudents($batch) {
        $batchEnd = $batch + 100000;
        return Studentterm::select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>=', $batch)->where('studentterms.studentid', '<', $batchEnd)->groupBy('studentterms.studentid')->orderBy('studentterms.studentid')->get();
    }

    //Get batch students (Program)
    public static function getBatchStudentsProgram($batch, $programid) {
        $batchEnd = $batch + 100000;
        return Studentterm::select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>=', $batch)->where('studentterms.studentid', '<', $batchEnd)->where('studentterms.programid', $programid)->groupBy('studentterms.studentid')->orderBy('studentterms.studentid')->get();
    }

    //Get batch students (Department)
    public static function getBatchStudentsDepartment($batch, $departmentid) {
        $batchEnd = $batch + 100000;
        $programids = Studentterm::getDeptPrograms($departmentid);

        return Studentterm::select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>=', $batch)->where('studentterms.studentid', '<', $batchEnd)->whereIn('studentterms.programid', $programids)->groupBy('studentterms.studentid')->orderBy('studentterms.studentid')->get();
    }

    //Get batch students (College)
    public static function getBatchStudentsCollege($batch, $collegeid) {
        $batchEnd = $batch + 100000;
        $programids = Studentterm::getCollPrograms($collegeid);

        return Studentterm::select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>=', $batch)->where('studentterms.studentid', '<', $batchEnd)->whereIn('studentterms.programid', $programids)->groupBy('studentterms.studentid')->orderBy('studentterms.studentid')->get();
    }

    //Get count of batch students
    public static function getBatchStudentsCount($batch) {
        $batchEnd = $batch + 100000;
        return count(Studentterm::select('studentterms.studentid')->join('programs', 'studentterms.programid', '=', 'programs.programid')->where('programs.degreelevel', 'U')->where('studentterms.studentid', '>=', $batch)->where('studentterms.studentid', '<', $batchEnd)->groupBy('studentterms.studentid')->get());
    }

    //Get count of batch students (Program)
    public static function getBatchStudentsCountProgram($batch, $programid) {
        $batchEnd = $batch + 100000;
        return count(Studentterm::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->where('programid', $programid)->groupBy('studentid')->get());
    }

    //Get count of batch students (Department)
    public static function getBatchStudentsCountDepartment($batch, $departmentid) {
        $batchEnd = $batch + 100000;
        $programids = Studentterm::getDeptPrograms($departmentid);

        return count(Studentterm::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->whereIn('programid', $programids)->groupBy('studentid')->get());
    }

    //Get count of batch students (College)
    public static function getBatchStudentsCountCollege($batch, $collegeid) {
        $batchEnd = $batch + 100000;
        $programids = Studentterm::getCollPrograms($collegeid);

        return count(Studentterm::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->whereIn('programid', $programids)->groupBy('studentid')->get());
    }

    //Get employment of student
    public static function getOneEmployment($studentId) {
        return Studentterm::select('employment')->where('studentid', $studentId)->get();
    }

    //Get average grade of student
    public static function getOneGrades($studentId) {
        return Studentterm::select('gwa')->where('studentid', $studentId)->where('gwa', '>', 1.00)->avg('gwa');
    }

    //Get stbracket of student
    public static function getOneStbracket($studentId) {
        return Studentterm::select('stfapbracket')->where('studentid', $studentId)->get();
    }

    //Get employment of student (Program)
    public static function getOneEmploymentProgram($studentId, $programid) {
        return Studentterm::select('employment')->where('studentid', $studentId)->where('programid', $programid)->get();
    }

    //Get average grade of student (Program)
    public static function getOneGradesProgram($studentId, $programid) {
        return Studentterm::select('gwa')->where('studentid', $studentId)->where('gwa', '>', 1.00)->where('programid', $programid)->avg('gwa');
    }

    //Get stbracket of student (Program)
    public static function getOneStbracketProgram($studentId, $programid) {
        return Studentterm::select('stfapbracket')->where('studentid', $studentId)->where('programid', $programid)->get();
    }

    //Get employment of student (Department)
    public static function getOneEmploymentDepartment($studentId, $departmentid) {
        $programids = Studentterm::getDeptPrograms($departmentid);
        return Studentterm::select('employment')->where('studentid', $studentId)->whereIn('programid', $programids)->get();
    }

    //Get average grade of student (Department)
    public static function getOneGradesDepartment($studentId, $departmentid) {
        $programids = Studentterm::getDeptPrograms($departmentid);
        return Studentterm::select('gwa')->where('studentid', $studentId)->where('gwa', '>', 1.00)->whereIn('programid', $programids)->avg('gwa');
    }

    //Get stbracket of student (Department)
    public static function getOneStbracketDepartment($studentId, $departmentid) {
        $programids = Studentterm::getDeptPrograms($departmentid);
        return Studentterm::select('stfapbracket')->where('studentid', $studentId)->whereIn('programid', $programids)->get();
    }

    //Get employment of student (College)
    public static function getOneEmploymentCollege($studentId, $collegeid) {
        $programids = Studentterm::getCollPrograms($collegeid);
        return Studentterm::select('employment')->where('studentid', $studentId)->whereIn('programid', $programids)->get();
    }

    //Get average grade of student (College)
    public static function getOneGradesCollege($studentId, $collegeid) {
        $programids = Studentterm::getCollPrograms($collegeid);
        return Studentterm::select('gwa')->where('studentid', $studentId)->where('gwa', '>', 1.00)->whereIn('programid', $programids)->avg('gwa');
    }

    //Get stbracket of student (College)
    public static function getOneStbracketCollege($studentId, $collegeid) {
        $programids = Studentterm::getCollPrograms($collegeid);
        return Studentterm::select('stfapbracket')->where('studentid', $studentId)->whereIn('programid', $programids)->get();
    }
}
