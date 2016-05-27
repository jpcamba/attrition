<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRowToFactorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('factors', function(Blueprint $table)
		{

		});

		$newRow = new Factor;
		$newRow->factorname = 'Units';
		$newRow->save();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('factors', function(Blueprint $table)
		{
			//
		});
	}

}
