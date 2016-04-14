<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReseedProgramAndUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	 public function up()
 	{
 		//program

 		$programlist = Program::where('programs.degreelevel', 'U')->whereNotIn('programs.programid', array(62, 66, 38, 22))->get();
 		foreach($programlist as $program){
 			$program->years_stay = $program->getAveYearsOfStay();
 			$program->years_before_shift = $program->getAveYearsBeforeShifting();
 			$program->years_before_drop = $program->getAveYearsBeforeDropout();
 			$program->ave_batch_attrition = $program->getAveAttrition();
 			$program->ave_batch_shift = $program->getAveShiftRate();
 			$program->ave_students = $program->getAveStudents();
 			$program->save(['timestamps' => false]);
 		}


 		//department

 		$departmentlist = Department::whereHas('programs', function($q){
     						$q->whereNotIn('programid', array(62, 66, 38, 22));
 							$q->where('degreelevel', 'U');
 						})->get();

 		foreach($departmentlist as $department){
 			$department->ave_batch_attrition = $department->getAveAttrition();
 			$department->ave_batch_shift = $department->getAveShiftRate();
 			$department->ave_students = $department->getAveStudents();
 			$department->save(['timestamps' => false]);
 		}


 		//college
 		$departmentlist = Department::whereHas('programs', function($q){
 							$q->whereNotIn('programid', array(62, 66, 38, 22));
 							$q->where('degreelevel', 'U');
 						})->get();

 		$collegelist = [];
 		foreach($departmentlist as $department){
 			array_push($collegelist, $department->college);
 		}
 		$collegelist = array_unique($collegelist);

 		foreach($collegelist as $college){
 			$college->ave_batch_attrition = $college->getAveAttrition();
 			$college->ave_batch_shift = $college->getAveShiftRate();
 			$college->ave_students = $college->getAveStudents();
 			$college->save(['timestamps' => false]);
 		}

 	}

 	/**
 	 * Reverse the migrations.
 	 *
 	 * @return void
 	 */
 	public function down()
 	{



 	}


}
