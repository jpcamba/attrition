<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollegeEntriesToCorrelationsTableOverload extends Migration {

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

			$this->seedOverload($batches, $allStudents, $collegeid);
		}
	}

	//Overloading Units factor
	public function seedOverload($batches, $allStudents, $collegeid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalOverload = 0;
			$totalNodata = 0;

			foreach ($students as $student) {
				$units = Assessment::getOneAveUnitsCollege($student->studentid, $collegeid);

				if ($units === -1)
					$totalNodata++;
				else if ($units > 18)
					$totalOverload++;
				else {}
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 9;
			$newCorrelation->batch = $batch;

			$countStudents = count($students);
			if ($countStudents - $totalNodata > 0)
				$newCorrelation->ratio = $totalOverload / ($countStudents - $totalNodata);
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
