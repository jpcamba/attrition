<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollegeEntriesToCorrelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$batches = [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009];
		$allStudents = [];
		$colleges = College::select('unitid')->get();

		foreach ($colleges as $college) {
			$collegeid = $college->unitid;
			foreach ($batches as $batch) {
				$allStudents[$batch] = Studentterm::getBatchStudentsCollege($batch * 100000, $collegeid);
			}

			$this->seedEmployment($batches, $allStudents, $collegeid);
			$this->seedGrades($batches, $allStudents, $collegeid);
			$this->seedStbracket($batches, $allStudents, $collegeid);
			$this->seedRegion($batches, $allStudents, $collegeid);
		}
	}

	//Employment factor
	public function seedEmployment($batches, $allStudents, $collegeid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalEmployed = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneEmploymentCollege($student->studentid, $collegeid);

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

			$newCorrelation->unittype = 'college';
			$newCorrelation->collegeid = $collegeid;
			$newCorrelation->save();
		}
	}

	//Grades factor
	public function seedGrades($batches, $allStudents, $collegeid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalFailing = 0;

			foreach ($students as $student) {
				if (Studentterm::getOneGradesCollege($student->studentid, $collegeid) > 3.00)
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

			$newCorrelation->unittype = 'college';
			$newCorrelation->collegeid = $collegeid;
			$newCorrelation->save();
		}
	}

	//ST Bracket Factor
	public function seedStbracket($batches, $allStudents, $collegeid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalPoor = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneStbracketCollege($student->studentid, $collegeid);

				$poor = 0;
				foreach ($results as $result) {
					if (strpos($result->stfapbracket, 'A') !== false || strpos($result->stfapbracket, 'B') || strpos($result->stfapbracket, '8') !== false || strpos($result->stfapbracket, '9') !== false)
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

			$newCorrelation->unittype = 'college';
			$newCorrelation->collegeid = $collegeid;
			$newCorrelation->save();
		}
	}

	//Region Factor
	public function seedRegion($batches, $allStudents, $collegeid) {
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
	}

}
