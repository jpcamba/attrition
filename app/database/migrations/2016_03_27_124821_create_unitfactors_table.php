<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitfactorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unitfactors', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->integer('unitid');
			$table->integer('factorid');
			$table->string('type');
			$table->decimal('value');
			$table->timestamps();
		});

		//seed table
		$campus = Campus::where('unitid', 2)->first();

		//employment
		$employmentArray = $campus->getEmploymentCount();
		//employed
		$employmentFactor = new Unitfactor;
		$employmentFactor->unitid = 2;
		$employmentFactor->factorid = 1;
		$employmentFactor->type = "Employed";
		$employmentFactor->value = $employmentArray['Employed'];
		$employmentFactor->save();
		//unemployed
		$employmentFactor = new Unitfactor;
		$employmentFactor->unitid = 2;
		$employmentFactor->factorid = 1;
		$employmentFactor->type = "Unemployed";
		$employmentFactor->value = $employmentArray['Unemployed'];
		$employmentFactor->save();

		//grades
		$gradeArray = $campus->getGradeCount();
		//passed
		$gradeFactor = new Unitfactor;
		$gradeFactor->unitid = 2;
		$gradeFactor->factorid = 2;
		$gradeFactor->type = "Passed";
		$gradeFactor->value = $gradeArray['Passed'];
		$gradeFactor->save();
		//failed
		$gradeFactor = new Unitfactor;
		$gradeFactor->unitid = 2;
		$gradeFactor->factorid = 2;
		$gradeFactor->type = "Failed";
		$gradeFactor->value = $gradeArray['Failed'];
		$gradeFactor->save();

		//region
		$regionArray = $campus->getRegionCount();
		//Luzon
		$regionFactor = new Unitfactor;
		$regionFactor->unitid = 2;
		$regionFactor->factorid = 4;
		$regionFactor->type = "Luzon";
		$regionFactor->value = $regionArray['Luzon'];
		$regionFactor->save();
		//Visayas
		$regionFactor = new Unitfactor;
		$regionFactor->unitid = 2;
		$regionFactor->factorid = 4;
		$regionFactor->type = "Visayas";
		$regionFactor->value = $regionArray['Visayas'];
		$regionFactor->save();
		//Mindanao
		$regionFactor = new Unitfactor;
		$regionFactor->unitid = 2;
		$regionFactor->factorid = 4;
		$regionFactor->type = "Mindanao";
		$regionFactor->value = $regionArray['Mindanao'];
		$regionFactor->save();

		//stbracketKey
		$stbracketArray = $campus->getSTBracketCount();
		//A
		$stbracketFactor = new Unitfactor;
		$stbracketFactor->unitid = 2;
		$stbracketFactor->factorid = 3;
		$stbracketFactor->type = "A";
		$stbracketFactor->value = $stbracketArray['A'];
		$stbracketFactor->save();
		//B
		$stbracketFactor = new Unitfactor;
		$stbracketFactor->unitid = 2;
		$stbracketFactor->factorid = 3;
		$stbracketFactor->type = "B";
		$stbracketFactor->value = $stbracketArray['B'];
		$stbracketFactor->save();
		//C
		$stbracketFactor = new Unitfactor;
		$stbracketFactor->unitid = 2;
		$stbracketFactor->factorid = 3;
		$stbracketFactor->type = "C";
		$stbracketFactor->value = $stbracketArray['C'];
		$stbracketFactor->save();
		//D
		$stbracketFactor = new Unitfactor;
		$stbracketFactor->unitid = 2;
		$stbracketFactor->factorid = 3;
		$stbracketFactor->type = "D";
		$stbracketFactor->value = $stbracketArray['D'];
		$stbracketFactor->save();
		//E1
		$stbracketFactor = new Unitfactor;
		$stbracketFactor->unitid = 2;
		$stbracketFactor->factorid = 3;
		$stbracketFactor->type = "E1";
		$stbracketFactor->value = $stbracketArray['E1'];
		$stbracketFactor->save();
		//E2
		$stbracketFactor = new Unitfactor;
		$stbracketFactor->unitid = 2;
		$stbracketFactor->factorid = 3;
		$stbracketFactor->type = "E2";
		$stbracketFactor->value = $stbracketArray['E2'];
		$stbracketFactor->save();

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('unitfactors', function(Blueprint $table)
		{
			//
			Schema::drop('unitfactors');
		});
	}

}
