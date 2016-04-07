<?php

class Correlation extends Eloquent {

    protected $table = 'correlations';
    protected $primaryKey = 'correlationid';

    public function factors() {
        return $this->hasOne('Factor', 'factorid');
    }

    public static function getEmployment() {
        return Correlation::select('batch', 'ratio')->where('factorid', 1)->get();
    }

    public static function getGrades() {
        return Correlation::select('batch', 'ratio')->where('factorid', 2)->get();
    }

    public static function getStbracket() {
        return Correlation::select('batch', 'ratio')->where('factorid', 3)->get();
    }

    public static function getRegion() {
        return Correlation::select('batch', 'ratio')->where('factorid', 4)->get();
    }

    public static function getUnits() {
        return Correlation::select('batch', 'ratio')->where('factorid', 6)->get();
    }

    public static function getHighGrades() {
        return Correlation::select('batch', 'ratio')->where('factorid', 7)->get();
    }

    public static function getUnemployment() {
        return Correlation::select('batch', 'ratio')->where('factorid', 8)->get();
    }

    public static function getOverloading() {
        return Correlation::select('batch', 'ratio')->where('factorid', 9)->get();
    }
}
