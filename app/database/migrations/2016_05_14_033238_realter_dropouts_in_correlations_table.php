<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RealterDropoutsInCorrelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('correlations', function(Blueprint $table)
		{
			//
		});

		$entries = Correlation::get();

		foreach ($entries as $entry) {
			if ($entry->unittype === 'campus')
				$this->seedCampus($entry);
			else if ($entry->unittype === 'college')
				$this->seedCollege($entry);
			else if ($entry->unittype === 'department')
				$this->seedDepartment($entry);
			else if ($entry->unittype === 'program')
				$this->seedProgram($entry);
			else {}
		}
	}

	//Seed dropouts by Campus
	public function seedCampus($entry) {
		$batch = $entry->batch;
		$dropouts = Studentdropout::getBatchDropoutsCount($batch * 100000);
		$students = Studentterm::getBatchStudentsCount($batch * 100000);

		if ($students > 0)
			$entry->dropouts = $dropouts / $students;
		else
			$entry->dropouts = 0;

		$entry->save();
	}	

	//Seed dropouts by College
	public function seedCollege($entry) {
		$batch = $entry->batch;
		$collegeid = $entry->collegeid;
		$dropouts = Studentdropout::getBatchDropoutsCountCollege($batch * 100000, $collegeid);
		$students = Studentterm::getBatchStudentsCountCollege($batch * 100000, $collegeid);

		if ($students > 0)
			$entry->dropouts = $dropouts / $students;
		else
			$entry->dropouts = 0;

		$entry->save();
	}	

	//Seed dropouts by Department
	public function seedDepartment($entry) {
		$batch = $entry->batch;
		$departmentid = $entry->departmentid;
		$dropouts = Studentdropout::getBatchDropoutsCountDepartment($batch * 100000, $departmentid);
		$students = Studentterm::getBatchStudentsCountDepartment($batch * 100000, $departmentid);

		if ($students > 0)
			$entry->dropouts = $dropouts / $students;
		else
			$entry->dropouts = 0;

		$entry->save();
	}		

	//Seed dropouts by Program
	public function seedProgram($entry) {
		$batch = $entry->batch;
		$programid = $entry->programid;
		$dropouts = Studentdropout::getBatchDropoutsCountProgram($batch * 100000, $programid);
		$students = Studentterm::getBatchStudentsCountProgram($batch * 100000, $programid);

		if ($entry->dropouts > 0)
			$entry->dropouts = $dropouts / $students;
		else
			$entry->dropouts = 0;
		
		$entry->save();
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
			//
		});
	}

}
