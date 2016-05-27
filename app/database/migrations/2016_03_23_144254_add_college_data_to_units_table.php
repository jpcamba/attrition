<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollegeDataToUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

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
		Schema::table('units', function(Blueprint $table)
		{
			//
		});
	}

}
