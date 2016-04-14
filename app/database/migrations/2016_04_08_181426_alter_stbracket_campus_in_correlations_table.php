<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStbracketCampusInCorrelationsTable extends Migration {

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
		$allStudents = [];

		foreach ($batches as $batch) {
			$allStudents[$batch] = Studentterm::getBatchStudents($batch * 100000);
		}

		$this->alterStbracket($batches, $allStudents);
	}

	//Alter stbracket column
	public function alterStbracket($batches, $allStudents) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalPoor = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneStbracket($student->studentid);

				$poor = 0;
				foreach ($results as $result) {
					if (strpos($result->stfapbracket, 'A') !== false || strpos($result->stfapbracket, 'B') !== false || strpos($result->stfapbracket, '8') !== false || strpos($result->stfapbracket, '9') !== false)
						$poor = 1;
				}

				$totalPoor = $totalPoor + $poor;
			}

			$entry = Correlation::where('batch', $batch)->where('unittype', 'campus')->where('factorid', 3)->first();

			$countStudents = count($students);
			if ($countStudents > 0)
				$entry->ratio = $totalPoor / $countStudents;
			else
				$entry->ratio = 0;

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
