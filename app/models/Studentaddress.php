<?php

class Studentaddress extends Eloquent {
    protected $table = 'studentaddresses';

    public function students(){
        return $this->belongsTo('Student', 'studentid');
    }

    public function cities() {
    	$this->hasOne('City', 'cityid');
    }

    public static function getOneRegion($studentId) {
    	return Studentaddress::select('regions.regioncode')->join('cities', 'studentaddresses.cityid', '=', 'cities.cityid')->join('provinces', 'cities.provinceid', '=', 'provinces.provinceid')->join('regions', 'provinces.regionid', '=', 'regions.regionid')->where('studentaddresses.studentid', $studentId)->first();
    }
}
