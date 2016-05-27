<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastprogramidToStudentdropoutsTable extends Migration {

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
			$table->integer('lastprogramid')->nullable();
		});

		$studentdropouts =  Studentdropout::all();

		foreach($studentdropouts as $dropout){
			$lastsem = DB::table('studentterms')->select(DB::raw('MAX(aysem) AS lastsem'))->where('studentid', $dropout->studentid)->lists(DB::raw('lastsem'));

			$lastsemdata = Studentterm::where('studentid', $dropout->studentid)->where('aysem', $lastsem[0])->first();
			$dropout->lastprogramid = $lastsemdata->programid;
			$dropout->save();
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
			$table->dropColumn('lastprogramid');
		});
	}

}
