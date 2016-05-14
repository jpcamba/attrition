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
}
