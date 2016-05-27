<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RealterDepartmentDropoutsInCorrelationsTable extends Migration {

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

		$entries = Correlation::where('unittype', 'department')->get();

		foreach ($entries as $entry) {
			$batch = $entry->batch;
			$departmentid = $entry->departmentid;
			$dropoutsRaw = Studentdropout::getBatchDropoutsDepartment($batch * 100000, $departmentid);
			$shiftsRaw = Studentshift::getBatchShiftsDepartment($batch * 100000, $departmentid);
			$delayedRaw = Studentdelayed::getBatchDelayedDepartment($batch * 100000, $departmentid);

			$studentids = [];
			foreach ($dropoutsRaw as $doRaw) {
				array_push($studentids, $doRaw->studentid);
			}

			foreach ($shiftsRaw as $sRaw) {
				array_push($studentids, $sRaw->studentid);
			}

			foreach ($delayedRaw as $dRaw) {
				array_push($studentids, $dRaw->studentid);
			}

			$studentids = array_values(array_unique($studentids));

			$students = Studentterm::getBatchStudentsCountDepartment($batch * 100000, $departmentid);

			if ($students > 0)
				$entry->dropouts = count($studentids) / $students;
			else
				$entry->dropouts = 0;

			$entry->save();
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
