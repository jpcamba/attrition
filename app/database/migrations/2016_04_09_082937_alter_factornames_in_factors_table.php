<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFactornamesInFactorsTable extends Migration {

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

		$entry = Factor::where('factorid', 2)->first();
		$entry->factorname = 'Low Grades';
		$entry->save();

		$entry = Factor::where('factorid', 3)->first();
		$entry->factorname = 'ST Bracket A & B';
		$entry->save();

		$entry = Factor::where('factorid', 6)->first();
		$entry->factorname = 'Underloading Units';
		$entry->save();

		$entry = Factor::where('factorid', 9)->first();
		$entry->factorname = 'Overloading Units';
		$entry->save();
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
