<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnitsFactorToCorrelationsTable extends Migration {

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

		$batches = [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009];

		foreach ($batches as $batch) {
			$students = Studentterm::getBatchStudents($batch * 100000);
			$totalUnderload = 0;
			$totalNodata = 0;

			foreach ($students as $student) {
				$units = Assessment::getOneAveUnits($student->studentid);

				if ($units === -1)
					$totalNodata++;
				else if ($units < 15)
					$totalUnderload++;
				else {}
			}

			$newEntry = new Correlation;
			$newEntry->factorid = 6;
			$newEntry->batch = $batch;
			$newEntry->ratio = $totalUnderload / (count($students) - $totalNodata);
			$newEntry->save();
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
