<?php

class Studentshift extends Eloquent
{
    protected $table = 'studentshifts';

    public function student(){
        return $this->belongsTo('Student', 'studentid');
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
    public static function getTotalShiftsCount() {
        return count(Studentshift::select('studentid')->get());
    }

    //Get batch students
    public static function getBatchShifts($batch) {
        $batchEnd = $batch + 100000;
        return Studentshift::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->groupBy('studentid')->orderBy('studentid')->get();
    }

    //Get count of batch students
    public static function getBatchShiftsCount($batch) {
        $batchEnd = $batch + 100000;
        return count(Studentshift::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->get());
    }

    //Get count of batch students (Program)
    public static function getBatchShiftsCountProgram($batch, $program1id) {
        $batchEnd = $batch + 100000;
        return count(Studentshift::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $programid)->get());
    }

    //Get count of batch students (Department)
    public static function getBatchShiftsCountDepartment($batch, $departmentid) {
        $batchEnd = $batch + 100000;
        $programids = Studentshift::getDeptPrograms($departmentid);
        return count(Studentshift::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->whereIn('program1id', $programids)->get());
    }

    //Get count of batch students (College)
    public static function getBatchShiftsCountCollege($batch, $collegeid) {
        $batchEnd = $batch + 100000;
        $programids = Studentshift::getCollPrograms($collegeid);
        return count(Studentshift::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->whereIn('program1id', $programids)->get());
    }

    //Get batch students (Program)
    public static function getBatchShiftsProgram($batch, $programid) {
        $batchEnd = $batch + 100000;
        return Studentshift::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->where('program1id', $programid)->get();
    }

    //Get batch students (Department)
    public static function getBatchShiftsDepartment($batch, $departmentid) {
        $batchEnd = $batch + 100000;
        $programids = Studentshift::getDeptPrograms($departmentid);
        return Studentshift::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->whereIn('program1id', $programids)->get();
    }

    //Get batch students (College)
    public static function getBatchShiftsCollege($batch, $collegeid) {
        $batchEnd = $batch + 100000;
        $programids = Studentshift::getCollPrograms($collegeid);
        return Studentshift::select('studentid')->where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->whereIn('program1id', $programids)->get();
    }
}
