<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentshiftsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('studentshifts', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->integer('studentid');
			$table->integer('program1id');
			$table->decimal('program1years');
			$table->integer('program2id');
			$table->decimal('program2years');
			$table->timestamps();
		});

		//create array of programids of graduate programs
		$mastersArray = DB::table('programs')->where('degreelevel', '!=', 'U')->where('programid', '!=', 38)->lists('programid');

		/*get list of students who shifted out
			1. Join studentterms to itself
			2. Get studentids of students who have studentterms with different programids
			3. Get their first and second programs
			4. Make sure the programs are not graduate programs
			5. Shifting should be done directly after the program1 aysem (ex. program1 aysem = 20101 and program2 = 20102 or program1 aysem = 20102 and program2 = 20111)
		*/
		$shiftees = DB::table('studentterms AS e1')
            ->join('studentterms AS e2', DB::raw('e1.studentid'), '=', DB::raw('e2.studentid'))
            ->select(DB::raw('e1.studentid AS studentid'), DB::raw('e1.programid AS program1'), DB::raw('e2.programid AS program2'))
			->where(DB::raw('e1.programid'), '!=', DB::raw('e2.programid'))
			->where(DB::raw('e1.studentid'), '>', 200000000)
			->whereNotIn(DB::raw('e1.programid'), $mastersArray)
			->whereNotIn(DB::raw('e2.programid'), $mastersArray)
			->whereIn(DB::raw('e2.aysem::Int4 - e1.aysem::Int4'), array(1, 9))
			->whereRaw('CAST(e1.aysem AS TEXT) NOT LIKE \'%3\'')
			->whereRaw('CAST(e2.aysem AS TEXT) NOT LIKE \'%3\'')
			->groupBy(DB::raw('e1.studentid'),  DB::raw('e1.programid'),  DB::raw('e2.programid'))
            ->get();

		/*Populate table:
		  	1. For each student, take note of their programs
			2. Get the number of sems they spent in each program, exclude summer (aysem ending in 3)
			3. Divide number of sems by 2 to get the number of years
		*/
		foreach($shiftees as $shiftee){
			$studentid = $shiftee->studentid;
			$program1id = $shiftee->program1;
			$program2id = $shiftee->program2;

			$program1sems = Studentterm::where('studentid', $studentid)->where('programid', $program1id)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->count();
			$program1years = $program1sems/2;

			$program2sems = Studentterm::where('studentid', $studentid)->where('programid', $program2id)->whereRaw('CAST(aysem AS TEXT) NOT LIKE \'%3\'')->count();
			$program2years = $program2sems/2;

			$studentshift = new Studentshift;
			$studentshift->studentid = $studentid;
			$studentshift->program1id = $program1id;
			$studentshift->program1years = $program1years;
			$studentshift->program2id = $program2id;
			$studentshift->program2years = $program2years;
			$studentshift->save();
		}

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('studentshifts', function(Blueprint $table)
		{
			//
			Schema::drop('studentshifts');
		});
	}

}
