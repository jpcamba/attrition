<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYearToStudenttermsTable extends Migration {

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
			$table->integer('year')->nullable();
		});

		DB::statement('UPDATE studentterms SET year = cast(substring(cast(aysem as text) from 1 for 4) as integer) WHERE char_length(aysem::varchar(255)) = 5');
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
			$table->dropColumn('year');
		});
	}

}
