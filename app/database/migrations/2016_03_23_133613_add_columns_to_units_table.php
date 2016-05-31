<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUnitsTable extends Migration {

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
			$table->decimal('ave_batch_attrition')->nullable();
			$table->decimal('ave_batch_shift')->nullable();
			$table->decimal('ave_students')->nullable();
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
			$table->dropColumn('ave_batch_attrition');
			$table->dropColumn('ave_batch_shift');
			$table->dropColumn('ave_students');
		});
	}

}
