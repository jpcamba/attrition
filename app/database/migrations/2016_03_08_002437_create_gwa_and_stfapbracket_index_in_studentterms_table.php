<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGwaAndStfapbracketIndexInStudenttermsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('studentterms', function(Blueprint $table)
		{
			$table->index('gwa', 'gwa_index');
			$table->index('stfapbracket', 'stfapbracket_index');
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
