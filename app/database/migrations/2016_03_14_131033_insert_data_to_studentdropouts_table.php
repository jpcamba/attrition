<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDataToStudentdropoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('studentdropouts', function(Blueprint $table)
		{
			//
			/*Add data to include Applied Physics (programid = 117) and batch 2011 and 2012
			1. Get all students from 2011 and 2012 who is taking applied physics
			2. Remove students who shifted out
			3. If batch 2011 and has no studentterm in 2012 and 2013 then add student to studentdropouts table
			4. If batch 2012 and has no studentterm in 2013 then add student to studentdropouts table
			*/
			$program = Program::where('programid', 117)->first();
			$shiftees = Studentshift::where('program1id', $program->programid)->lists('studentid');
			$min = 201100000;
			$max = 201300000;

			$studentids = Studentterm::select('studentid')->where('studentid', '>', $min)->where('studentid', '<', $max)->whereNotIn('studentid', $shiftees)->where('programid', $program->programid)->groupBy('studentid')->lists('studentid');

			foreach($studentids as $studentid){
				$student = Student::where('studentid', $studentid)->first();
				if($student->studentid < 201200000){ //batch 2011
					$stayed = $student->studentterms()->where('year', 2012)->orWhere('year', 2013)->count();
				}
				else{ //batch 2012
					$stayed = $student->studentterms()->where('year', 2013)->count();
				}
				if($stayed === 0){ //insert to studentdropout
					$semcount = $student->studentterms()->where('programid', $program->programid)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->count();
					$newDropout = new Studentdropout; 
					$newDropout->studentid = $student->studentid; 
					$newDropout->programid = $program->programid; 
					$newDropout->lastprogramid = $program->programid; 
					$newDropout->collegeid = $program->department->college->unitid; 
					$newDropout->semesters = $semcount;
					$newDropout->save();
				}
			}

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('studentdropouts', function(Blueprint $table)
		{
			//
		});
	}

}
