<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentdelayedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('studentdelayed', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('studentid');
			$table->integer('programid');
			$table->integer('collegeid');
			$table->integer('semesters');
			$table->timestamps();
		});

		$students = Studentdropout::select('studentid', 'programid', 'collegeid', 'semesters')->where('semesters', '>', 8)->get();

		foreach ($students as $student) {
			$programid = $student->programid;
			$semesters = $student->semesters;
			$programYears = Program::select('numyears')->where('programid', $programid)->first()->numyears;

			if ($semesters > $programYears * 2) {
				$newEntry = new Studentdelayed;
				$newEntry->studentid = $student->studentid;
				$newEntry->programid = $programid;
				$newEntry->collegeid = $student->collegeid;
				$newEntry->semesters = $semesters;
				$newEntry->save();
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
		Schema::drop('studentdelayed');
	}

}
