<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProgramEntriesToCorrelationsTable extends Migration {

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

			$this->seedEmployment($batches, $allStudents, $programid);
			$this->seedGrades($batches, $allStudents, $programid);
			$this->seedStbracket($batches, $allStudents, $programid);
			$this->seedRegion($batches, $allStudents, $programid);
			$this->seedUnemployment($batches, $allStudents, $programid);
			$this->seedHighGrades($batches, $allStudents, $programid);
			$this->seedOverload($batches, $allStudents, $programid);
			$this->seedUnits($batches, $allStudents, $programid);
		}
	}

	//Employment factor
	public function seedEmployment($batches, $allStudents, $programid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalEmployed = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneEmploymentProgram($student->studentid, $programid);

				$employed = 0;
				foreach ($results as $result) {
					if ($result->employment === 'F' || $result->employment === 'P')
						$employed = 1;
				}

				$totalEmployed = $totalEmployed + $employed;
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 1;
			$newCorrelation->batch = $batch;

			$countStudents = count($students);
			if ($countStudents > 0)
				$newCorrelation->ratio = $totalEmployed / $countStudents;
			else
				$newCorrelation->ratio = 0;

			$newCorrelation->unittype = 'program';
			$newCorrelation->programid = $programid;
			$newCorrelation->save();
		}
	}

	//Grades factor
	public function seedGrades($batches, $allStudents, $programid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalFailing = 0;		

			foreach ($students as $student) {
				if (Studentterm::getOneGradesProgram($student->studentid, $programid) > 3.00)
					$totalFailing++;
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 2;
			$newCorrelation->batch = $batch;

			$countStudents = count($students);
			if ($countStudents > 0)
				$newCorrelation->ratio = $totalFailing / $countStudents;
			else
				$newCorrelation->ratio = 0;

			$newCorrelation->unittype = 'program';
			$newCorrelation->programid = $programid;
			$newCorrelation->save();
		}
	}

	//ST Bracket Factor
	public function seedStbracket($batches, $allStudents, $programid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalPoor = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneStbracketProgram($student->studentid, $programid);

				$poor = 0;
				foreach ($results as $result) {
					if (strpos($result->stfapbracket, 'A') !== false || strpos($result->stfapbracket, 'B') !== false || strpos($result->stfapbracket, '8') !== false || strpos($result->stfapbracket, '9') !== false)
						$poor = 1;
				}

				$totalPoor = $totalPoor + $poor;
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 3;
			$newCorrelation->batch = $batch;

			$countStudents = count($students);
			if ($countStudents > 0)
				$newCorrelation->ratio = $totalPoor / $countStudents;
			else
				$newCorrelation->ratio = 0;

			$newCorrelation->unittype = 'program';
			$newCorrelation->programid = $programid;
			$newCorrelation->save();
		}
	}

	//Region Factor
	public function seedRegion($batches, $allStudents, $programid) {
		$regions = ['VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'ARMM'];

		foreach ($batches as $batch) {
			$totalFar = 0;
			$students = $allStudents[$batch];

			foreach ($students as $student) {
				$regionHolder = Studentaddress::getOneRegion($student->studentid);
				if (count($regionHolder) > 0) {
					if (in_array($regionHolder->regioncode, $regions))
						$totalFar++;
				}
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 4;
			$newCorrelation->batch = $batch;

			$countStudents = count($students);
			if ($countStudents > 0)
				$newCorrelation->ratio = $totalFar / $countStudents;
			else
				$newCorrelation->ratio = 0;

			$newCorrelation->unittype = 'program';
			$newCorrelation->programid = $programid;
			$newCorrelation->save();
		}
	}

	//Unemployment factor
	public function seedUnemployment($batches, $allStudents, $programid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalUnemployed = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneEmploymentProgram($student->studentid, $programid);

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
			
			$newCorrelation->unittype = 'program';
			$newCorrelation->programid = $programid;
			$newCorrelation->save();
		}
	}

	//High Grades factor
	public function seedHighGrades($batches, $allStudents, $programid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalHigh = 0;

			foreach ($students as $student) {
				$gwa = Studentterm::getOneGradesProgram($student->studentid, $programid);
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

			$newCorrelation->unittype = 'program';
			$newCorrelation->programid = $programid;
			$newCorrelation->save();
		}
	}

	//Overloading Units factor
	public function seedOverload($batches, $allStudents, $programid) {
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

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 9;
			$newCorrelation->batch = $batch;

			$countStudents = count($students);
			if ($countStudents - $totalNodata > 0)
				$newCorrelation->ratio = $totalOverload / ($countStudents - $totalNodata);
			else
				$newCorrelation->ratio = 0;

			$newCorrelation->unittype = 'program';
			$newCorrelation->programid = $programid;
			$newCorrelation->save();
		}			
	}

	//Underloading Units factor
	public function seedUnits($batches, $allStudents, $programid) {
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

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 6;
			$newCorrelation->batch = $batch;

			$countStudents = count($students);
			if ($countStudents - $totalNodata > 0)
				$newCorrelation->ratio = $totalUnderload / ($countStudents - $totalNodata);
			else
				$newCorrelation->ratio = 0;

			$newCorrelation->unittype = 'program';
			$newCorrelation->programid = $programid;
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
