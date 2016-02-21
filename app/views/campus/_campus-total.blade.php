<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Overall
            </div>
            <div class="panel-body">
                <div id="campus-total-dropouts"></div>
                <center>
                    <h4>Average number of students per year</h4>
                    <div id="campus-number-students"></div>
                    </br></br>
                    <h4>Difference between semesters per year</h4>
                    <div id="campus-sem-difference"></div>
                    </br></br>
                    <h4>Average number of years a student spends in the university</h4>
                    <h1>{{ $aveYearsOfStay }}</h1>

                    {{-- var_dump($studenttermsArray) --}}
            		{{-- var_dump(DB::getQueryLog()) --}}
            		{{--var_dump( 'I only swim butterfly')--}}
                    {{-- var_dump(count($students)) --}}

                </center>
            </div>
        </div>
    </div>
</div>
