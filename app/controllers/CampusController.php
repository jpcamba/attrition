<?php


class CampusController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//get array of sem and number of students
	/*	$aysemRaw = DB::select('select aysem, count (*) as studentcount
		from studentterms
		where aysem::varchar(255) NOT LIKE \'%3\'
		group by aysem
		having count(*) > 300
		order by aysem asc;');*/

		$aysemRaw = DB::table('studentterms')
					->select('aysem', DB::raw('COUNT (*) as studentcount'))
					->whereRaw('char_length(aysem::varchar(255)) = 5 and aysem::varchar(255) NOT LIKE \'%3\'')
					->groupBy('aysem')
					->havingRaw('count(*) > 1')
					->orderBy('aysem', 'asc')
					->get();


		//create array of year and number of students
		$yearlyStudentsArray = array();

		$students = 0;
		$prevYear = "";
		$prevStudents = 0;
		$testingyear = "";
		$testingstuds = 0;

		foreach($aysemRaw as $yearData){
			$currentYear = substr($yearData->aysem, 0, 4);
			$currentStudents = $yearData->studentcount;
			if($prevYear === ""){
				$prevYear = $currentYear;
				$prevStudents = $currentStudents;
			}
			elseif($prevYear === $currentYear){
				$students = $prevStudents + $currentStudents;
				$yearlyStudentsArray[$currentYear] = $students;
				$prevYear = "";
			}
		}

		//return page
		return View::make('campus.campus', array('yearlyStudentsArray' => $yearlyStudentsArray));

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
