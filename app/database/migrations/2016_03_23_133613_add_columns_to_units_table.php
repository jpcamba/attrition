<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('units', function(Blueprint $table)
		{
			//
			$table->decimal('ave_batch_attrition')->nullable();
			$table->decimal('ave_batch_shift')->nullable();
			$table->decimal('ave_students')->nullable();
		});

		/*$departmentlist = Department::whereHas('programs', function($q){
    						$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->get();

		foreach($departmentlist as $department){
			$department->ave_batch_attrition = $department->getAveAttrition();
			$department->ave_batch_shift = $department->getAveShiftRate();
			$department->ave_students = $department->getAveStudents();
			$department->save(['timestamps' => false]);
		}*/
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
			$table->dropColumn('ave_batch_attrition');
			$table->dropColumn('ave_batch_shift');
			$table->dropColumn('ave_students');
		});
	}

}
