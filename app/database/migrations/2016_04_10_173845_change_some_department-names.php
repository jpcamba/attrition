<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSomeDepartmentNames extends Migration {

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
			$departmentlist = Department::whereHas('programs', function($q){
	     						$q->whereNotIn('programid', array(62, 66, 38, 22));
	 							$q->where('degreelevel', 'U');
	 						})->get();

	 		foreach($departmentlist as $department){
				$unitname = $department->unitname;
				if(strpos($unitname, 'Department of') !== false){
					$unitname = str_replace("Department of ","", $unitname);
					$unitname = substr_replace($unitname, " Department", strlen($unitname), 0);
				}
				$department->unitname = $unitname;
				$department->save(['timestamps' => false]);
	 		}

			foreach($departmentlist as $department){
				$unitname = $department->unitname;
				if(strpos($unitname, ' Department') !== false){
					$unitname = str_replace(" Department","", $unitname);
					$unitname = substr_replace($unitname, "Department of ", 0, 0);
				}
				$department->unitname = $unitname;
				$department->save(['timestamps' => false]);
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
		Schema::table('units', function(Blueprint $table)
		{
			//
		});
	}

}
