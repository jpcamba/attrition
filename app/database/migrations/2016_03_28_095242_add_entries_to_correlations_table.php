<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntriesToCorrelationsTable extends Migration {

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

		$this->addEntries();
	}

	//Add new entries
	public function addEntries() {
		$batches = [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009];
		$allStudents = [];

		foreach ($batches as $batch) {
			$allStudents[$batch] = Studentterm::getBatchStudents($batch * 100000);
		}

		$this->seedUnemployment($batches, $allStudents);
		$this->seedHighGrades($batches, $allStudents);
		$this->seedOverload($batches, $allStudents);
	}

	//Unemployment factor
	public function seedUnemployment($batches, $allStudents) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalUnemployed = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneEmployment($student->studentid);

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
			$newCorrelation->ratio = $totalUnemployed / count($students);
			$newCorrelation->save();
		}
	}

	//High Grades factor
	public function seedHighGrades($batches, $allStudents) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalHigh = 0;

			foreach ($students as $student) {
				$gwa = Studentterm::getOneGrades($student->studentid);
				if ($gwa > 0.00 || $gwa < 3.00)
					$totalHigh++;
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 7;
			$newCorrelation->batch = $batch;
			$newCorrelation->ratio = $totalHigh / count($students);
			$newCorrelation->save();
		}
	}

	//Overloading Units factor
	public function seedOverload($batches, $allStudents) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalOverload = 0;
			$totalNodata = 0;

			foreach ($students as $student) {
				$units = Assessment::getOneAveUnits($student->studentid);

				if ($units === -1)
					$totalNodata++;
				else if ($units > 18)
					$totalOverload++;
				else {}
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 9;
			$newCorrelation->batch = $batch;
			$newCorrelation->ratio = $totalOverload / (count($students) - $totalNodata);
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
