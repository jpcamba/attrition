<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCampusDropoutsInCorrelationsTable extends Migration {

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

		$entries = Correlation::where('unittype', 'campus')->get();

		foreach ($entries as $entry) {
			$batch = $entry->batch;
			$dropouts = Studentdropout::getBatchDropoutsCount($batch * 100000);
			$delayed = Studentdelayed::getBatchDelayedCount($batch * 100000);
			$students = Studentterm::getBatchStudentsCount($batch * 100000);

			if ($students > 0)
				$entry->dropouts = ($dropouts + $delayed) / $students;
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
