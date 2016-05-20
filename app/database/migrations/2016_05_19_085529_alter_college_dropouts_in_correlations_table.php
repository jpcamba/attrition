<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCollegeDropoutsInCorrelationsTable extends Migration {

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

		$entries = Correlation::where('unittype', 'college')->get();

		foreach ($entries as $entry) {
			$batch = $entry->batch;
			$collegeid = $entry->collegeid;
			$dropoutsRaw = Studentdropout::getBatchDropoutsCollege($batch * 100000, $collegeid);
			$shiftsRaw = Studentshift::getBatchShiftsCollege($batch * 100000, $collegeid);
			$delayedRaw = Studentdelayed::getBatchDelayedCollege($batch * 100000, $collegeid);

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

			$students = Studentterm::getBatchStudentsCountCollege($batch * 100000, $collegeid);

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
