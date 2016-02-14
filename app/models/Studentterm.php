<?php

class Studentterm extends Eloquent {
    protected $table = 'studentterms';

    public function student()
        {
            return $this->belongsTo('Student', 'studentid');
        }
}
