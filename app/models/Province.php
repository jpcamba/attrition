<?php

class Province extends Eloquent {
    protected $table = 'provinces';

    public function cities(){
        return $this->hasMany('City', 'provinceid');
    }

    public function regions() {
    	return $this->belongsTo('Region', 'provinceid');
    }
}
