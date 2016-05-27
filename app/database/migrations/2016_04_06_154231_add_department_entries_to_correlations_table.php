<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentEntriesToCorrelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$batches = [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009];
		$allStudents = [];
		$departments = Department::select('unitid')->get();

		foreach ($departments as $department) {
			$departmentid = $department->unitid;
			foreach ($batches as $batch) {
				$allStudents[$batch] = Studentterm::getBatchStudentsDepartment($batch * 100000, $departmentid);
			}

			$this->seedEmployment($batches, $allStudents, $departmentid);
			$this->seedGrades($batches, $allStudents, $departmentid);
			$this->seedStbracket($batches, $allStudents, $departmentid);
			$this->seedRegion($batches, $allStudents, $departmentid);
			$this->seedUnemployment($batches, $allStudents, $departmentid);
			$this->seedHighGrades($batches, $allStudents, $departmentid);
			$this->seedOverload($batches, $allStudents, $departmentid);
			$this->seedUnits($batches, $allStudents, $departmentid);
		}
	}

	//Employment factor
	public function seedEmployment($batches, $allStudents, $departmentid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalEmployed = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneEmploymentDepartment($student->studentid, $departmentid);

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
			
			$newCorrelation->unittype = 'department';
			$newCorrelation->departmentid = $departmentid;
			$newCorrelation->save();
		}
	}

	//Grades factor
	public function seedGrades($batches, $allStudents, $departmentid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalFailing = 0;

			foreach ($students as $student) {
				if (Studentterm::getOneGradesDepartment($student->studentid, $departmentid) > 3.00)
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

			$newCorrelation->unittype = 'department';
			$newCorrelation->departmentid = $departmentid;
			$newCorrelation->save();
		}
	}

	//ST Bracket Factor
	public function seedStbracket($batches, $allStudents, $departmentid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalPoor = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneStbracketDepartment($student->studentid, $departmentid);

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

			$newCorrelation->unittype = 'department';
			$newCorrelation->departmentid = $departmentid;
			$newCorrelation->save();
		}
	}

	//Region Factor
	public function seedRegion($batches, $allStudents, $departmentid) {
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

			$newCorrelation->unittype = 'department';
			$newCorrelation->departmentid = $departmentid;
			$newCorrelation->save();
		}
	}

	//Unemployment factor
	public function seedUnemployment($batches, $allStudents, $departmentid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalUnemployed = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneEmploymentDepartment($student->studentid, $departmentid);

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

			$newCorrelation->unittype = 'department';
			$newCorrelation->departmentid = $departmentid;
			$newCorrelation->save();
		}
	}

	//High Grades factor
	public function seedHighGrades($batches, $allStudents, $departmentid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalHigh = 0;

			foreach ($students as $student) {
				$gwa = Studentterm::getOneGradesDepartment($student->studentid, $departmentid);
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

			$newCorrelation->unittype = 'department';
			$newCorrelation->departmentid = $departmentid;
			$newCorrelation->save();
		}
	}

	//Overloading Units factor
	public function seedOverload($batches, $allStudents, $departmentid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalOverload = 0;
			$totalNodata = 0;

			foreach ($students as $student) {
				$units = Assessment::getOneAveUnitsDepartment($student->studentid, $departmentid);

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
			
			$newCorrelation->unittype = 'department';
			$newCorrelation->departmentid = $departmentid;
			$newCorrelation->save();
		}
	}

	//Underloading Units factor
	public function seedUnits($batches, $allStudents, $departmentid) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalUnderload = 0;
			$totalNodata = 0;

			foreach ($students as $student) {
				$units = Assessment::getOneAveUnitsDepartment($student->studentid, $departmentid);

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
			
			$newCorrelation->unittype = 'department';
			$newCorrelation->departmentid = $departmentid;
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
