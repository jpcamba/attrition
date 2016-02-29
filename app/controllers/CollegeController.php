<?php

class CollegeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	 public function index()
 	{
		$collegelist = College::whereHas('programs', function($q){
    						$q->whereNotIn('programid', array(62, 66, 38, 22));
							$q->where('degreelevel', 'U');
						})->get();


 		//Averaage students per program
 		$collegeAveArray = [];
 		foreach($collegelist as $college){
 			$collStudents = round($college->getAveStudents(), 2);
			$collegeAveArray[$college->unitname] = $collStudents;
 		}

 		//return page
 		return View::make('college.college',
 		['collegelist' => $collegelist,
 		 'collegeAveArray' => $collegeAveArray
 		]);

 	}

	public function showSpecificCollege(){
	    $collegeIDInput = Input::get('college-dropdown');
	    $college = College::find($collegeIDInput);

	    //ave students per year and ave difference
	    $yearsArray = Year::all();
	    $yearlyStudentAverage = [];
	    $yearlySemDifference = [];
	    foreach($yearsArray as $yearData){
	        $aveStudents = $college->getYearlyAveStudents($yearData->year);
	        if($aveStudents > 1){
	            $yearlyStudentAverage[$yearData->year] = $aveStudents;
	        }
	        $semDiff = $college->getYearlySemDifference($yearData->year);
	        $yearlySemDifference[$yearData->year] = $semDiff;
	    }

	    return View::make('college.college-specific',
	    ['college' => $college,
	     'yearlyStudentAverage' => $yearlyStudentAverage,
	     'yearlySemDifference' => $yearlySemDifference
	    ]);
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
