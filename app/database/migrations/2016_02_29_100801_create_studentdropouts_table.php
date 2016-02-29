<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentdropoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('studentdropouts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('studentid');
			$table->integer('programid');
			$table->integer('collegeid');
			$table->integer('semesters');
			$table->timestamps();
		});

		$students = DB::table('studentterms')->join('programs', 'studentterms.programid', '=', 'programs.programid')->select('studentterms.studentid as studentid')->where('studentterms.studentid', '>', 200000000)->where('studentterms.studentid', '<', 201000000)->where('programs.degreelevel', '=', 'U')->groupBy('studentterms.studentid')->orderBy('studentterms.studentid')->get();

		foreach ($students as $student) {
			$studentId = $student->studentid;
			
			//It won't matter if student shifted or whatever (more years in student's stay), the point here is he will be counted as a dropout if his stay is less than his required stay (assuming there are no early graduates)
			$programId = DB::table('studentterms')->select('studentid', 'programid', 'unitid', 'aysem')->where('studentid', '=', $studentId)->first()->programid;
			if ($programId === 0 || $programId === 1 || $programId === 49 || $programId === 54 || $programId === 100 || $programId === 114)
				$programSems = 8;
			else
				$programSems = DB::table('programs')->where('programid', '=', $programId)->first()->numyears * 2;
			//for Intarmed, etc
			if ($programSems > 10 || $programSems < 8)
				$programSems = 8;
			$studentSems = 0;

			$studentOnes = DB::table('studentterms')->select('studentid', 'programid', 'unitid', 'aysem')->where('studentid', '=', $studentId)->get();
			foreach ($studentOnes as $studentOne) {
				$studentSemstr = substr($studentOne->aysem, -1);
				if ($studentSemstr === '1')
					$studentSems++;
				if ($studentSemstr === '2')
					$studentSems++;
			}

			if ($studentSems < $programSems) {
				$newDropout = new Studentdropout;
				$newDropout->studentid = $studentId;
				$newDropout->programid = $programId;

				if ($programId === 0 || $programId === 1 || $programId === 49 || $programId === 54 || $programId === 100 || $programId === 114)
					$collegeId = 0;
				else
					$collegeId = DB::table('programs')->select('unitid')->where('programid', '=', $programId)->first()->unitid;

				$newDropout->collegeid = $collegeId;
				$newDropout->semesters = $studentSems;
				$newDropout->save();
			}
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('studentdropouts');
	}
}