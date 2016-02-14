<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('years', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('year');
			$table->timestamps();
		});

		$aysemRaw = DB::table('studentterms')
					->select('aysem', DB::raw('COUNT (*) as studentcount'))
					->whereRaw('char_length(aysem::varchar(255)) = 5 and aysem::varchar(255) NOT LIKE \'%3\'')
					->groupBy('aysem')
					->havingRaw('count(*) > 1')
					->orderBy('aysem', 'asc')
					->get();

		$prevYear = 0;
		foreach($aysemRaw as $yearData){
			$currentYear = substr($yearData->aysem, 0, 4);
			if($prevYear === 0){
				$prevYear = $currentYear;
			}
			elseif($prevYear === $currentYear){
				$yearObj = new Year;
				$yearObj->year = $currentYear;
				$yearObj->save();
				//DB::table('years')->insert(array('year' => $currentYear));
				$prevYear = 0;
			}
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('years');
	}

}
