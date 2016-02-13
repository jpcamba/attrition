<?php

class Studentterm extends Eloquent {

    public function student()
        {
            return $this->belongsTo('Student');
        }
}
