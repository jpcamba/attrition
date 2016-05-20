<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CleanDepartmentsCollegesInCorrelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('correlations', function(Blueprint $table)
		{
			//
		});

		$departmentlist = Department::whereHas('programs', function($q){
    						$q->whereNotIn('programid', array(62, 66, 38));
							$q->where('degreelevel', 'U');
						})->get();

		$collegelist = [];
		$departmentids = [];
		foreach($departmentlist as $department){
			array_push($collegelist, $department->college);
			array_push($departmentids, $department->unitid);
		}
		$collegelist = array_unique($collegelist);

		$collegeids = [];
		foreach ($collegelist as $college) {
			array_push($collegeids, $college->unitid);
		}

		$entries = Correlation::where('unittype', 'college')->orWhere('unittype', 'department')->get();

		foreach ($entries as $entry) {
			if ($entry->unittype === 'college') {
				$collegeid = $entry->collegeid;

				if (in_array($collegeid, $collegeids)) {}
				else
					$entry->delete();
			}

			elseif ($entry->unittype === 'department') {
				$departmentid = $entry->departmentid;

				if (in_array($departmentid, $departmentids)) {}
				else
					$entry->delete();
			}

			else {}
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('correlations', function(Blueprint $table)
		{
			//
		});
	}

}
