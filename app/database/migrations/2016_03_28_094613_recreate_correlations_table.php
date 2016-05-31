<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateCorrelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('correlations', function(Blueprint $table)
		{
			$table->increments('correlationid');
			$table->integer('factorid');
			$table->integer('batch');
			$table->float('ratio');
			$table->timestamps();
		});

		$this->seedCorrelations();
	}

	//Seed correlation
	public function seedCorrelations() {
		$batches = [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009];
		$allStudents = [];

		foreach ($batches as $batch) {
			$allStudents[$batch] = Studentterm::getBatchStudents($batch * 100000);
		}

		$this->seedEmployment($batches, $allStudents);
		$this->seedGrades($batches, $allStudents);
		$this->seedStbracket($batches, $allStudents);
		$this->seedRegion($batches, $allStudents);
	}

	//Employment factor
	public function seedEmployment($batches, $allStudents) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalEmployed = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneEmployment($student->studentid);

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
			$newCorrelation->ratio = $totalEmployed / count($students);
			$newCorrelation->save();
		}
	}

	//Grades factor
	public function seedGrades($batches, $allStudents) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalFailing = 0;

			foreach ($students as $student) {
				if (Studentterm::getOneGrades($student->studentid) > 3.00)
					$totalFailing++;
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 2;
			$newCorrelation->batch = $batch;
			$newCorrelation->ratio = $totalFailing / count($students);
			$newCorrelation->save();
		}
	}

	//ST Bracket Factor
	public function seedStbracket($batches, $allStudents) {
		foreach ($batches as $batch) {
			$students = $allStudents[$batch];
			$totalPoor = 0;

			foreach ($students as $student) {
				$results = Studentterm::getOneStbracket($student->studentid);

				$poor = 0;
				foreach ($results as $result) {
					if (strpos($result->stfapbracket, 'A') !== false || strpos($result->stfapbracket, 'B') !== false)
						$poor = 1;
				}

				$totalPoor = $totalPoor + $poor;
			}

			$newCorrelation = new Correlation;
			$newCorrelation->factorid = 3;
			$newCorrelation->batch = $batch;
			$newCorrelation->ratio = $totalPoor / count($students);
			$newCorrelation->save();
		}
	}

	//Region Factor
	public function seedRegion($batches, $allStudents) {
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
			$newCorrelation->ratio = $totalFar / count($students);
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
		Schema::drop('correlations');
	}

}
