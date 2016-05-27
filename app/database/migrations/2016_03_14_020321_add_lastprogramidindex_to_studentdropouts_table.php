<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastprogramidindexToStudentdropoutsTable extends Migration {

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
			$table->index('lastprogramid', 'lastprogramid_index');
		});
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
			$table->dropIndex('lastprogramid_index');
		});
	}

}
