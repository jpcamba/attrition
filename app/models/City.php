<?php

class City extends Eloquent {
    protected $table = 'cities';

    public function studentaddresses(){
        return $this->belongsTo('Studentaddress', 'cityid');
    }

    public function provinces() {
    	return $this->belongsTo('Province', 'cityid');
    }
}
