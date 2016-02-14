<?php

class Year extends Eloquent {

    protected $table = 'years';
    public $studentsSem1Count = 0;
    public $studentsSem2Count = 0;

    public function countSem1Students(){
        $this->studentsSem1Count = Studentterm::whereRaw(('substring(aysem::varchar(255) for 4) LIKE :thisYear and aysem::varchar(255) LIKE \'%1\''), array('thisYear' => $this->year))->count();
    }

    public function countSem2Students(){
        $this->studentsSem2Count = Studentterm::whereRaw(('substring(aysem::varchar(255) for 4) LIKE :thisYear and aysem::varchar(255) LIKE \'%2\''), array('thisYear' => $this->year))->count();
    }

    public function getAveStudents() {
        if($this->studentsSem1Count === 0){
            $this->countSem1Students();
        }
        if($this->studentsSem2Count === 0){
            $this->countSem2Students();
        }

        $studentsSem1 = $this->studentsSem1Count;
        $studentsSem2 = $this->studentsSem2Count;

        $aveStudents = ($studentsSem1 + $studentsSem2)/2;
        return $aveStudents;
    }

    public function getSemDifference() {
        if($this->studentsSem1Count === 0){
            $this->countSem1Students();
        }
        if($this->studentsSem2Count === 0){
            $this->countSem2Students();
        }

        $studentsSem1 = $this->studentsSem1Count;
        $studentsSem2 = $this->studentsSem2Count;

        $semDifference = $studentsSem1 - $studentsSem2;
        return $semDifference;
    }


    /*//Alternative but not working
    public function getAveStudents(){
        $records = Studentterm::whereRaw(('substring(aysem::varchar(255) for 4) LIKE :thisYear'), array('thisYear' => $this->year))->get();
        $studentsSem1 = 0;
        $studentsSem2 = 0;
        foreach($records as $sem){
            if(substr($sem->aysem, -1) == '1'){
                $studentsSem1 = $studentsSem1++;
            }
            else{
                $studentsSem2 = $studentsSem2++;
            }
        }
    }*/
}
