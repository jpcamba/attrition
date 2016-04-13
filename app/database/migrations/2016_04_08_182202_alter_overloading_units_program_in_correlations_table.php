<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOverloadingUnitsProgramInCorrelationsTable extends Migration {

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
		$programs = Program::select('programid')->get();

		foreach ($programs as $program) {
			$programid = $program->programid;
			foreach ($batches as $batch) {
				$allStudents[$batch] = Studentterm::getBatchStudentsProgram($batch * 100000, $programid);
			}

			$this->alterOverload($batches, $allStudents, $programid);
			$this->alterUnits($batches, $allStudents, $programid);
		}
	}

	//Overloading Units factor
	public function alterOverload($batches, $allStudents, $programid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalOverload = 0;
			$totalNodata = 0;

			foreach ($students as $student) {
				$units = Assessment::getOneAveUnitsProgram($student->studentid, $programid);

				if ($units === -1)
					$totalNodata++;
				else if ($units > 18)
					$totalOverload++;
				else {}
			}

			$entry = Correlation::where('batch', $batch)->where('unittype', 'program')->where('programid', $programid)->where('factorid', 9)->first();

			$countStudents = count($students);
			if ($countStudents - $totalNodata > 0)
				$entry->ratio = $totalOverload / ($countStudents - $totalNodata);
			else
				$entry->ratio = 0;

			$entry->save();
		}			
	}

	//Underloading Units factor
	public function alterUnits($batches, $allStudents, $programid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalUnderload = 0;
			$totalNodata = 0;

			foreach ($students as $student) {
				$units = Assessment::getOneAveUnitsProgram($student->studentid, $programid);

				if ($units === -1)
					$totalNodata++;
				else if ($units < 15)
					$totalUnderload++;
				else {}
			}

			$entry = Correlation::where('batch', $batch)->where('unittype', 'program')->where('programid', $programid)->where('factorid', 6)->first();

			$countStudents = count($students);
			if ($countStudents - $totalNodata > 0)
				$entry->ratio = $totalUnderload / ($countStudents - $totalNodata);
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
