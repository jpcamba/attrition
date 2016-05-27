<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollegeEntriesToCorrelationsTableUnemployment extends Migration {

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
		$colleges = College::select('unitid')->get();

		foreach ($colleges as $college) {
			$collegeid = $college->unitid;
			foreach ($batches as $batch) {
				$allStudents[$batch] = Studentterm::getBatchStudentsCollege($batch * 100000, $collegeid);
			}

			$this->seedUnemployment($batches, $allStudents, $collegeid);
		}
	}

	//Unemployment factor
	public function seedUnemployment($batches, $allStudents, $collegeid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalUnemployed = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneEmploymentCollege($student->studentid, $collegeid);

				$unemployed = 0;
				foreach ($results as $result) {
					if ($result->employment === 'N')
						$unemployed = 1;
				}

				$totalUnemployed = $totalUnemployed + $unemployed;
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 8;
			$newCorrelation->batch = $batch;

			$countStudents = count($students);
			if ($countStudents > 0)
				$newCorrelation->ratio = $totalUnemployed / $countStudents;
			else
				$newCorrelation->ratio = 0;

			$newCorrelation->unittype = 'college';
			$newCorrelation->collegeid = $collegeid;
			$newCorrelation->save();
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
