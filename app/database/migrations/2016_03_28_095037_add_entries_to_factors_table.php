<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntriesToFactorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('factors', function(Blueprint $table)
		{
			//
		});

		$newFactor = new Factor;
		$newFactor->factorname = "High Grades";
		$newFactor->save();

		$newFactor = new Factor;
		$newFactor->factorname = "Unemployment";
		$newFactor->save();

		$newFactor = new Factor;
		$newFactor->factorname = "Overloading";
		$newFactor->save();
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
