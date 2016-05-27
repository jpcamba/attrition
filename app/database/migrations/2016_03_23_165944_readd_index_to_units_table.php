<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReAddIndexToUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('units', function(Blueprint $table)
		{
			//
			$table->index('ave_batch_attrition', 'ave_batch_attrition_index');
			$table->index('ave_batch_shift', 'ave_batch_shift_index');
			$table->index('ave_students', 'ave_students_index');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('units', function(Blueprint $table)
		{
			//
			$table->dropIndex('ave_batch_attrition_index');
			$table->dropIndex('ave_batch_shift_index');
			$table->dropIndex('ave_students_index');
		});
	}

}
