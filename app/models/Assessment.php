<?php

class Assessment extends Eloquent {
    protected $table = 'assessment';

    public function student(){
        return $this->belongsTo('Student', 'studentid');
    }

    //Get programids that belong in department
    public static function getDeptPrograms($departmentid) {
        $programs = Program::select('programid')->where('unitid', $departmentid)->groupBy('programid')->get();
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

        $programs = Program::select('programid')->whereIn('unitid', $departmentids)->groupBy('programid')->get();
        $programids = [];

        foreach ($programs as $program) {
            array_push($programids, $program->programid);
        }

        return $programids;
    }

    //Get average units of student
    public static function getOneAveUnits($studentid) {
        $semesters = Assessment::select('total_units', 'aysem')->where('studentid', $studentid)->get();
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

    //Get average units of student (Program)
    public static function getOneAveUnitsProgram($studentid, $programid) {
        $semesters = Assessment::select('total_units', 'aysem')->where('studentid', $studentid)->get();
        $totalUnits = 0;
        $totalSemesters = 0;
        $aysemGet = Studentterm::select('aysem')->where('studentid', $studentid)->where('programid', $programid)->get();
        $aysems = [];

        foreach ($aysemGet as $aysem) {
            array_push($aysems, $aysem->aysem);
        }

        foreach ($semesters as $semester) {
            $semesterAysem = $semester->aysem;
            if (in_array($semesterAysem, $aysems) && (substr($semesterAysem, -1) === '1' || substr($semesterAysem, -1) === '2')) {
                $totalUnits = $totalUnits + $semester->total_units;
                $totalSemesters++;
            }
        }

        if ($totalSemesters > 0)
            return $totalUnits / $totalSemesters;
        else
            return -1;
    }

    //Get average units of student (Department)
    public static function getOneAveUnitsDepartment($studentid, $departmentid) {
        $programids = Assessment::getDeptPrograms($departmentid);
        $semesters = Assessment::select('total_units', 'aysem')->where('studentid', $studentid)->get();
        $totalUnits = 0;
        $totalSemesters = 0;
        $aysemGet = Studentterm::select('aysem')->where('studentid', $studentid)->whereIn('programid', $programids)->get();
        $aysems = [];

        foreach ($aysemGet as $aysem) {
            array_push($aysems, $aysem->aysem);
        }

        foreach ($semesters as $semester) {
            $semesterAysem = $semester->aysem;
            if (in_array($semesterAysem, $aysems) && (substr($semesterAysem, -1) === '1' || substr($semesterAysem, -1) === '2')) {
                $totalUnits = $totalUnits + $semester->total_units;
                $totalSemesters++;
            }
        }

        if ($totalSemesters > 0)
            return $totalUnits / $totalSemesters;
        else
            return -1;
    }

    //Get average units of student (College)
    public static function getOneAveUnitsCollege($studentid, $collegeid) {
        $programids = Assessment::getCollPrograms($collegeid);
        $semesters = Assessment::select('total_units', 'aysem')->where('studentid', $studentid)->get();
        $totalUnits = 0;
        $totalSemesters = 0;
        $aysemGet = Studentterm::select('aysem')->where('studentid', $studentid)->whereIn('programid', $programids)->get();
        $aysems = [];

        foreach ($aysemGet as $aysem) {
            array_push($aysems, $aysem->aysem);
        }

        foreach ($semesters as $semester) {
            $semesterAysem = $semester->aysem;
            if (in_array($semesterAysem, $aysems) && (substr($semesterAysem, -1) === '1' || substr($semesterAysem, -1) === '2')) {
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