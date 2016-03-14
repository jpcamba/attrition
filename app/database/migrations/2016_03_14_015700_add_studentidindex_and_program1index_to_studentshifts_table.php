<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentidindexAndProgram1indexToStudentshiftsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('studentshifts', function(Blueprint $table)
		{
			//
			//$table->index('studentid', 'studentid_index');
			$table->index('program1id', 'program1id_index');
			$table->index('program1years', 'program1years_index');
		});
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
			//$table->dropIndex('studentid_index');
			$table->dropIndex('program1id_index');
			$table->dropIndex('program1years_index');
		});
	}

}
