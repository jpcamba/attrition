<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteDelayedFromStudentdropoutsTable extends Migration {

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

		$students = Studentdropout::select('id', 'programid', 'semesters')->where('semesters', '>', 8)->get();

		foreach ($students as $student) {
			$programYears = Program::select('numyears')->where('programid', $student->programid)->first()->numyears;

			if ($student->semesters > $programYears * 2)
				Studentdropout::find($student->id)->delete();
		}
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
