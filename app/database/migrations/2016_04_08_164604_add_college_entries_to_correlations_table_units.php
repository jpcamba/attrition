<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollegeEntriesToCorrelationsTableUnits extends Migration {

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

			$this->seedUnits($batches, $allStudents, $collegeid);
		}
	}

	//Underloading Units factor
	public function seedUnits($batches, $allStudents, $collegeid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalUnderload = 0;
			$totalNodata = 0;

			foreach ($students as $student) {
				$units = Assessment::getOneAveUnitsCollege($student->studentid, $collegeid);

				if ($units === -1)
					$totalNodata++;
				else if ($units < 15)
					$totalUnderload++;
				else {}
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 6;
			$newCorrelation->batch = $batch;

			$countStudents = count($students);
			if ($countStudents - $totalNodata > 0)
				$newCorrelation->ratio = $totalUnderload / ($countStudents - $totalNodata);
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
