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
}
