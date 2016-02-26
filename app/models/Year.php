<?php

class Year extends Eloquent {

    protected $table = 'years';
    protected $primaryKey = 'year';

    public $studentsSem1Count = 0;
    public $studentsSem2Count = 0;

    public function studentterms(){
        return $this->hasMany('Studentterm', 'year');
    }

    public function countSem1Students(){
        return $this->studentsSem1Count = $this->studentterms()->join('programs', 'programs.programid', '=', 'studentterms.programid')->where('programs.degreelevel', 'U')->whereNotIn('programs.programid', array(62, 66, 38, 22))->where('aysem', strval($this->year).'1' )->count();
    }

    public function countSem2Students(){
        return $this->studentsSem1Count = $this->studentterms()->join('programs', 'programs.programid', '=', 'studentterms.programid')->where('programs.degreelevel', 'U')->whereNotIn('programs.programid', array(62, 66, 38, 22))->where('aysem', strval($this->year).'2')->count();
        //$this->studentsSem1Count = $this->studentterms()->where('aysem', '*2')->count();
        //$this->studentsSem2Count = Studentterm::whereRaw(('substring(aysem::varchar(255) for 4) LIKE :thisYear and aysem::varchar(255) LIKE \'%2\''), array('thisYear' => $this->year))->count();
    }

    public function countSem1ProgramStudents($programid){
        return $this->studentsSem1Count = $this->studentterms()->join('programs', 'programs.programid', '=', 'studentterms.programid')->where('programs.programid', '=', $programid)->where('aysem', strval($this->year).'1' )->count();
    }

    public function countSem2ProgramStudents($programid){
        return $this->studentsSem1Count = $this->studentterms()->join('programs', 'programs.programid', '=', 'studentterms.programid')->where('programs.programid', '=', $programid)->where('aysem', strval($this->year).'2' )->count();
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

    public function getAveProgramStudents($programid) {
        $programStudentsSem1 = $this->countSem1ProgramStudents($programid);
        $programStudentsSem2 = $this->countSem2ProgramStudents($programid);

        $aveStudents = ($programStudentsSem1 + $programStudentsSem2)/2;
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

    public function getProgramSemDifference($programid) {
        $studentsSem1 = $this->countSem1ProgramStudents($programid);
        $studentsSem2 = $this->countSem2ProgramStudents($programid);

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
