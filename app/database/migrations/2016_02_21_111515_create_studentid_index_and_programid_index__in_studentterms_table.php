<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentidIndexAndProgramidIndexInStudenttermsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('studentterms', function(Blueprint $table)
		{
			//
			$table->index('studentid', 'studentid_index');
			$table->index('programid', 'programid_index');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('studentterms', function(Blueprint $table)
		{
			//
		});
	}

}
