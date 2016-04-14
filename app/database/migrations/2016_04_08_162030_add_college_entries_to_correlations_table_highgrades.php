<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollegeEntriesToCorrelationsTableHighgrades extends Migration {

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

			$this->seedHighGrades($batches, $allStudents, $collegeid);
		}
	}

	//High Grades factor
	public function seedHighGrades($batches, $allStudents, $collegeid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalHigh = 0;

			foreach ($students as $student) {
				$gwa = Studentterm::getOneGradesCollege($student->studentid, $collegeid);
				if ($gwa > 1.00 || $gwa < 3.00)
					$totalHigh++;
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 7;
			$newCorrelation->batch = $batch;

			$countStudents = count($students);
			if ($countStudents > 0)
				$newCorrelation->ratio = $totalHigh / $countStudents;
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
