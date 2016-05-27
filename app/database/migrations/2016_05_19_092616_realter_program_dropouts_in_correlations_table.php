<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RealterProgramDropoutsInCorrelationsTable extends Migration {

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

		$entries = Correlation::where('unittype', 'program')->get();

		foreach ($entries as $entry) {
			$batch = $entry->batch;
			$programid = $entry->programid;
			$dropoutsRaw = Studentdropout::getBatchDropoutsProgram($batch * 100000, $programid);
			$shiftsRaw = Studentshift::getBatchShiftsProgram($batch * 100000, $programid);
			$delayedRaw = Studentdelayed::getBatchDelayedProgram($batch * 100000, $programid);

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

			$students = Studentterm::getBatchStudentsCountProgram($batch * 100000, $programid);

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
