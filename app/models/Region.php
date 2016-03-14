<?php

class Region extends Eloquent {
    protected $table = 'regions';

    public function provinces(){
        return $this->hasMany('Province', 'regionid');
    }
}
