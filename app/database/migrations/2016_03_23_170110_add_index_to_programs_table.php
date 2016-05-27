<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToProgramsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('programs', function(Blueprint $table)
		{
			//
			$table->index('ave_batch_attrition', 'program_ave_batch_attrition_index');
			$table->index('ave_batch_shift', 'program_ave_batch_shift_index');
			$table->index('ave_students', 'program_ave_students_index');
			$table->index('years_stay', 'years_stay_index');
			$table->index('years_before_shift', 'years_before_shift_index');
			$table->index('years_before_drop', 'years_before_drop_index');
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
			$table->dropIndex('program_ave_batch_attrition_index');
			$table->dropIndex('program_ave_batch_shift_index');
			$table->dropIndex('program_ave_students_index');
			$table->dropIndex('years_stay_index');
			$table->dropIndex('years_before_shift_index');
			$table->dropIndex('years_before_drop_index');
		});
	}

}
