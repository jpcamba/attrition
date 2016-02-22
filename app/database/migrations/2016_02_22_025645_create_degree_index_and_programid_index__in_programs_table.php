<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDegreeIndexAndProgramidIndexInProgramsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//DB::statement('ALTER TABLE programs DROP CONSTRAINT degree_index;');

		Schema::table('programs', function(Blueprint $table)
		{
			//
			//$table->index('degree', 'degree_index');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('programs', function(Blueprint $table)
		{
			//
		});
	}

}
