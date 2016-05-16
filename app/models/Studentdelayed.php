<?php

class Studentdelayed extends Eloquent {

    protected $table = 'studentdelayed';
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

    //Get batch delayed students
    public static function getBatchDelayedCount($batch) {
        $batchEnd = $batch + 100000;
        $programs = Program::whereNotIn('programid', array(62, 66, 38))->where('degreelevel', 'U')->lists('programid');
        $delayedCount = Studentdelayed::where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->wherein('programid', $programs)->count();

        return $delayedCount;
    }

    //Get batch delayed students (College)
    public static function getBatchDelayedCountCollege($batch, $collegeid) {
        $batchEnd = $batch + 100000;
        $college = College::where('unitid', $collegeid)->first();
        $programs = $college->programs()->whereNotIn('programid', array(62, 66, 38))->where('degreelevel', 'U')->lists('programid');

        if($collegeid != 7){
            $delayedCount = Studentdelayed::where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->wherein('programid', $programs)->count();
        }
        else{ //if intarmed student
            $batchStudents = Studentterm::getBatchStudents($batch);
            $delayedCount = 0;
            foreach($batchStudents as $batchStudent){
                $studentsems = Studentterm::countStudentSem($batchStudent->studentid, 28);
                $programYears = Program::select('numyears')->where('programid', 28)->first()->numyears;
                if ($studentsems > $programYears * 2) {
                    $delayedCount++;
                }
            }
        }

        return $delayedCount;
    }

    //Get batch delayed students (Department)
    public static function getBatchDelayedCountDepartment($batch, $departmentid) {
        $batchEnd = $batch + 100000;
        $department = Department::where('unitid', $departmentid)->first();
        $programs = $department->programs()->whereNotIn('programid', array(62, 66, 38))->where('degreelevel', 'U')->lists('programid');

        if($departmentid != 17){
            $delayedCount = Studentdelayed::where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->wherein('programid', $programs)->count();
        }
        else{ //if intarmed student
            $batchStudents = Studentterm::getBatchStudents($batch);
            $delayedCount = 0;
            foreach($batchStudents as $batchStudent){
                $studentsems = Studentterm::countStudentSem($batchStudent->studentid, 28);
                $programYears = Program::select('numyears')->where('programid', 28)->first()->numyears;
                if ($studentsems > $programYears * 2) {
                    $delayedCount++;
                }
            }
        }

        return $delayedCount;
    }

    //Get batch delayed students (Program)
    public static function getBatchDelayedCountProgram($batch, $programid) {
        $batchEnd = $batch + 100000;
        if($programid != 28){
            $delayedCount = Studentdelayed::where('studentid', '>=', $batch)->where('studentid', '<', $batchEnd)->where('programid', $programid)->count();
        }
        else{ //if intarmed student
            $batchStudents = Studentterm::getBatchStudents($batch);
            $delayedCount = 0;
            foreach($batchStudents as $batchStudent){
                $studentsems = Studentterm::countStudentSem($batchStudent->studentid, 28);
                $programYears = Program::select('numyears')->where('programid', 28)->first()->numyears;
                if ($studentsems > $programYears * 2) {
                    $delayedCount++;
                }
            }
        }

        return $delayedCount;
    }
}
