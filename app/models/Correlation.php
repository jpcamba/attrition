<?php

class Correlation extends Eloquent {

    protected $table = 'correlations';
    protected $primaryKey = 'correlationid';

    public function factors() {
        return $this->hasOne('Factor', 'factorid');
    }

    //Campus
    public static function getEmployment($level, $levelid = null) {
        switch ($level) {
            case 'campus':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 1)->where('unittype', 'campus')->get();
            case 'college':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 1)->where('unittype', 'college')->where('collegeid', $levelid)->get();
            case 'department':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 1)->where('unittype', 'department')->where('departmentid', $levelid)->get();
            case 'program':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 1)->where('unittype', 'program')->where('programid', $levelid)->get();
            default:
                # code...
                break;
        }
    }

    //Grades
    public static function getGrades($level, $levelid = null) {
        switch ($level) {
            case 'campus':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 2)->where('unittype', 'campus')->get();
            case 'college':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 2)->where('unittype', 'college')->where('collegeid', $levelid)->get();
            case 'department':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 2)->where('unittype', 'department')->where('departmentid', $levelid)->get();
            case 'program':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 2)->where('unittype', 'program')->where('programid', $levelid)->get();
            default:
                # code...
                break;
        }
    }

    //ST Bracket
    public static function getStbracket($level, $levelid = null) {
        switch ($level) {
            case 'campus':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 3)->where('unittype', 'campus')->get();
            case 'college':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 3)->where('unittype', 'college')->where('collegeid', $levelid)->get();
            case 'department':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 3)->where('unittype', 'department')->where('departmentid', $levelid)->get();
            case 'program':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 3)->where('unittype', 'program')->where('programid', $levelid)->get();
            default:
                # code...
                break;
        }
    }

    //Region
    public static function getRegion($level, $levelid = null) {
        switch ($level) {
            case 'campus':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 4)->where('unittype', 'campus')->get();
            case 'college':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 4)->where('unittype', 'college')->where('collegeid', $levelid)->get();
            case 'department':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 4)->where('unittype', 'department')->where('departmentid', $levelid)->get();
            case 'program':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 4)->where('unittype', 'program')->where('programid', $levelid)->get();
            default:
                # code...
                break;
        }
    }

    //Units
    public static function getUnits($level, $levelid = null) {
        switch ($level) {
            case 'campus':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 6)->where('unittype', 'campus')->get();
            case 'college':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 6)->where('unittype', 'college')->where('collegeid', $levelid)->get();
            case 'department':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 6)->where('unittype', 'department')->where('departmentid', $levelid)->get();
            case 'program':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 6)->where('unittype', 'program')->where('programid', $levelid)->get();
            default:
                # code...
                break;
        }
    }

    //High Grades
    public static function getHighGrades($level, $levelid = null) {
        switch ($level) {
            case 'campus':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 7)->where('unittype', 'campus')->get();
            case 'college':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 7)->where('unittype', 'college')->where('collegeid', $levelid)->get();
            case 'department':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 7)->where('unittype', 'department')->where('departmentid', $levelid)->get();
            case 'program':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 7)->where('unittype', 'program')->where('programid', $levelid)->get();
            default:
                # code...
                break;
        }
    }

    //Unemployment
    public static function getUnemployment($level, $levelid = null) {
        switch ($level) {
            case 'campus':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 8)->where('unittype', 'campus')->get();
            case 'college':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 8)->where('unittype', 'college')->where('collegeid', $levelid)->get();
            case 'department':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 8)->where('unittype', 'department')->where('departmentid', $levelid)->get();
            case 'program':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 8)->where('unittype', 'program')->where('programid', $levelid)->get();
            default:
                # code...
                break;
        }
    }

    //Overloading
    public static function getOverloading($level, $levelid = null) {
        switch ($level) {
            case 'campus':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 9)->where('unittype', 'campus')->get();
            case 'college':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 9)->where('unittype', 'college')->where('collegeid', $levelid)->get();
            case 'department':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 9)->where('unittype', 'department')->where('departmentid', $levelid)->get();
            case 'program':
                return Correlation::select('batch', 'ratio', 'dropouts')->where('factorid', 9)->where('unittype', 'program')->where('programid', $levelid)->get();
            default:
                # code...
                break;
        }
    }
}
