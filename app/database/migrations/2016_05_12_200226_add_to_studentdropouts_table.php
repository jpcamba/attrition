<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToStudentdropoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('studentdropouts', function(Blueprint $table)
		{
			//
		});

		$students = Studentterm::getAllStudents();

		foreach ($students as $student) {
			$studentid = $student->studentid;
			$programid = $this->getFinProgram($studentid);
			$programYears = Program::select('numyears')->where('programid', $programid)->first()->numyears;
			$studentsems = $this->countStudentSem($studentid, $programid);

			if ($studentsems > $programYears * 2) {
				$newEntry = new Studentdropout;
				$newEntry->studentid = $studentid;
				$newEntry->programid = $programid;
				$newEntry->collegeid = Program::select('unitid')->where('programid', $programid)->first()->unitid;
				$newEntry->semesters = $studentsems;
				$newEntry->save();
			}
		}
	}

	public function getFinProgram($studentid) {
		$aysemsRaw = Studentterm::select('aysem')->where('studentid', $studentid)->get();
		$aysems = [];

		foreach ($aysemsRaw as $aysemRaw) {
			array_push($aysems, $aysemRaw->aysem);
		}

		$maxAysem = max($aysems);
		$programid = Studentterm::select('programid')->where('studentid', $studentid)->where('aysem', $maxAysem)->first()->programid;

		while ($programid <= 0) {
			$aysems = array_diff($aysems, array($maxAysem));
			$maxAysem = max($aysems);
			$programid = Studentterm::select('programid')->where('studentid', $studentid)->where('aysem', $maxAysem)->first()->programid;
		}

		return $programid;
	}

	public function countStudentSem($studentid, $programid) {
		$aysems = Studentterm::select('aysem')->where('studentid', $studentid)->where('programid', $programid)->get();
		$sems = 0;

		foreach ($aysems as $aysem) {
			$sem = substr($aysem->aysem, -1);
			if ($sem === '1' || $sem === '2')
				$sems = $sems + 1;
		}

		return $sems;
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('studentdropouts', function(Blueprint $table)
		{
			//
		});
	}

}
