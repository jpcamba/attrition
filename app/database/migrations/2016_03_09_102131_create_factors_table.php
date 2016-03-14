<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('factors', function(Blueprint $table)
		{
			$table->increments('factorid');
			$table->string('factorname');
			$table->timestamps();
		});

		//Add rows (factors) to database
		$newFactor = new Factor;
		$newFactor->factorname = 'Employment';
		$newFactor->save();

		$newFactor = new Factor;
		$newFactor->factorname = 'Grades';
		$newFactor->save();

		$newFactor = new Factor;
		$newFactor->factorname = 'ST Bracket';
		$newFactor->save();

		$newFactor = new Factor;
		$newFactor->factorname = 'Region';
		$newFactor->save();

		$newFactor = new Factor;
		$newFactor->factorname = 'Tuition';
		$newFactor->save();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('factors');
	}

}
