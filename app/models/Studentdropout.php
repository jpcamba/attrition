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

    //Get total students
    public static function getTotalDropoutsCount() {
        return count(Studentdropout::select('studentid')->get());
    }

    //Get batch students
    public static function getBatchDropouts($batch) {
        $batchEnd = $batch + 100000;
        return Studentdropout::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->groupBy('studentid')->orderBy('studentid')->get();
    }

    //Get count of batch students
    public static function getBatchDropoutsCount($batch) {
        $batchEnd = $batch + 100000;
        return count(Studentdropout::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->get());
    }

    //Get count of batch students (Program)
    public static function getBatchDropoutsCountProgram($batch, $programid) {
        $batchEnd = $batch + 100000;
        return count(Studentdropout::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->where('programid', $programid)->get());
    }

    //Get count of batch students (Department)
    public static function getBatchDropoutsCountDepartment($batch, $departmentid) {
        $batchEnd = $batch + 100000;
        $programids = Studentdropout::getDeptPrograms($departmentid);
        return count(Studentdropout::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->whereIn('programid', $programids)->get());
    }

    //Get count of batch students (College)
    public static function getBatchDropoutsCountCollege($batch, $collegeid) {
        $batchEnd = $batch + 100000;
        $programids = Studentdropout::getCollPrograms($collegeid);
        return count(Studentdropout::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->whereIn('programid', $programids)->get());
    }
}
