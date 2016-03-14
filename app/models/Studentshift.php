<?php

class Studentshift extends Eloquent
{
    protected $table = 'studentshifts';

    public function student(){
        return $this->belongsTo('Student', 'studentid');
    }
}
