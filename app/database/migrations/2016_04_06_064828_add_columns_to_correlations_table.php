<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCorrelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('correlations', function(Blueprint $table)
		{
			$table->float('dropouts')->nullable();
			$table->string('unittype')->nullable();
			$table->integer('programid')->nullable();
			$table->integer('departmentid')->nullable();
			$table->integer('collegeid')->nullable();
		});

		$entries = Correlation::get();

		foreach ($entries as $entry) {
			$entry->unittype = 'campus';
			$entry->save();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('correlations', function(Blueprint $table)
		{
			$table->dropColumn('dropouts');
			$table->dropColumn('unittype');
			$table->dropColumn('programid');
			$table->dropColumn('departmentid');
			$table->dropColumn('collegeid');
		});
	}

}
