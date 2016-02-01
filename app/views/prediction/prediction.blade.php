@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('prediction/_prediction-sidebar')

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Prediction <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Choose Year Panel -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <center>Choose Year, College, and Program</center>
            </div>
            <div class="panel-body">
                <div class="col-md-4">
                    <form action="#" method="get">
                        <div class="input-group" style="width:200px">
                            <select class="form-control" required="required" id="year-dropdown" name="year-dropdown">
                                <option value="">Choose Year</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form action="#" method="get">
                        <div class="input-group" style="width:200px">
                            <select class="form-control" required="required" id="college-dropdown" name="college-dropdown">
                                <option value="">Choose College</option>
                                <option value="All Colleges">All Colleges</option>
                                <option value="College of Arts and Letters">College of Arts and Letters</option>
                                <option value="College of Fine Arts">College of Fine Arts</option>
                                <option value="College of Human Kinetics">College of Human Kinetics</option>
                                <option value="College of Mass Communication">College of Mass Communication</option>
                                <option value="College of Music">College of Music</option>
                                <option value="Asian Institute of Tourism">Asian Institute of Tourism</option>
                                <option value="Cesar E.A. Virata School of Business">Cesar E.A. Virata School of Business</option>
                                <option value="School of Economics">School of Economics</option>
                                <option value="School of Labor and Industrial Relations">School of Labor and Industrial Relations</option>
                                <option value="National College of Public Administration and Governance">National College of Public Administration and Governance</option>
                                <option value="School of Urban and Regional Planning">School of Urban and Regional Planning</option>
                                <option value="Archaeological Studies Program">Archaeological Studies Program</option>
                                <option value="College of Architecture">College of Architecture</option>
                                <option value="College of Engineering" >College of Engineering</option>
                                <option value="College of Home Economics">College of Home Economics</option>
                                <option value="College of Science">College of Science</option>
                                <option value="School of Library and Information Studies">School of Library and Information Studies</option>
                                <option value="stat">School of Statistics</option>
                                <option value="Asian Center">Asian Center</option>
                                <option value="College of Education">College of Education</option>
                                <option value="Institute of Islamic Studies">Institute of Islamic Studies</option>
                                <option value="College of Law">College of Law</option>
                                <option value="College of Social Sciences and Philosophy">College of Social Sciences and Philosophy</option>
                                <option value="College of Social Work and Community Development">College of Social Work and Community Development</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form action="#" method="get">
                        <div class="input-group" style="width:200px">
                            <select class="form-control" id="program-dropdown" name="program-dropdown">
                                <option value="">Choose Program</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Selected Options Panel -->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <strong>Showing Prediction for: </strong>
            <span id="prediction-year"></span>
            <span id="prediction-college"></span>
            <span id="prediction-program"></span>
        </div>
    </div>
</div>

<!-- Total Number of Dropouts/Attrition Rate Panel -->
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Total Attrition Rate</h4>
                    <h1>
                        <div id="prediction-total-rate"></div>
                    </h1>
                </center>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Total Number of Dropouts</h4>
                    <h1>
                        <div id="prediction-total-dropouts"></div>
                    </h1>
                </center>
            </div>
        </div>
    </div>
</div>

<!-- Employment Panel -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Total Number of Dropouts per Employment Type
            </div>
            <div class="panel-body">
                <div id="employment-total-dropouts"></div>
            </div>
        </div>
    </div>
</div>

<!-- Housing Panel -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Total Number of Dropouts per Housing Type
            </div>
            <div class="panel-body">
                <div id="housing-total-dropouts"></div>
            </div>
        </div>
    </div>
</div>


<!-- Grades Panel -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Total Number of Dropouts per Grade Range
            </div>
            <div class="panel-body">
                <div id="grades-total-dropouts"></div>
            </div>
        </div>
    </div>
</div>


<!-- ST Discount Panel -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Total Number of Dropouts per ST Discount Bracket
            </div>
            <div class="panel-body">
                <div id="stdiscount-total-dropouts"></div>
            </div>
        </div>
    </div>
</div>

<!-- Units Panel -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Total Number of Dropouts per Semester Units Range
            </div>
            <div class="panel-body">
                <div id="units-total-dropouts"></div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Info Panel -->
<div class="row">
    <div class="col-md-12">
        <h3 class="page-header">
            Additional Information
        </h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Total Money Spent on Dropouts</h4>
                    <h1 id="wasted-money"></h1>
                </center>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <center>
                    <h4>Average Years to Graduate</h4>
                    <h1 id="average-years"></h1>
                </center>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Please choose year.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@stop
<!-- /. ROW  -->

@section('javascript')

<script>
    //Get random number
    function getRandom() {
        return Math.floor(Math.random() * (3000 - 1000 + 1)) + 1000;
    }

    //Refresh and show graphs
    function showGraphs() {
        //Total Rate
        var rateRand = Math.floor(Math.random() * (100 - 0 + 1)) + 0;
        $('#prediction-total-rate').empty();
        $('#prediction-total-rate').append(rateRand + '%');
        
        //Total Dropouts
        $('#prediction-total-dropouts').empty();
        $('#prediction-total-dropouts').append(getRandom());

        //Employment Graph
        $('#employment-total-dropouts').empty();
        var employment = new Morris.Bar({
            element: 'employment-total-dropouts',
            data: [
                {type: 'Unemployed',value: getRandom()},
                {type: 'Part-time', value: getRandom()},
                {type: 'Full-time', value: getRandom()}
            ],
            xkey: 'type',
            ykeys: ['value'],
            labels: ['Total Number of Dropouts'],
            hideHover: 'auto'
        });

        //Housing Graph
        $('#housing-total-dropouts').empty();
        var housing = new Morris.Bar({
            element: 'housing-total-dropouts',
            data: [
                {type: 'UP Dormitory',value: getRandom()},
                {type: 'Own House', value: getRandom()},
                {type: 'Boarding House On-Campus', value: getRandom()},
                {type: 'Boarding House Off-Campus', value: getRandom()},
                {type: 'Rented House', value: getRandom()},
                {type: 'Relatives/Guardians House', value: getRandom()}
            ],
            xkey: 'type',
            ykeys: ['value'],
            labels: ['Total Number of Dropouts'],
            hideHover: 'auto',
            barColors: ['#1cc09f']
        });

        //Grades Graph
        $('#grades-total-dropouts').empty();
        var grades = new Morris.Bar({
            element: 'grades-total-dropouts',
            data: [
                {type: '1-1.99',value: getRandom()},
                {type: '2-2.99', value: getRandom()},
                {type: '3-3.99', value: getRandom()},
                {type: '4-4.99', value: getRandom()},
                {type: '5', value: getRandom()}
            ],
            xkey: 'type',
            ykeys: ['value'],
            labels: ['Total Number of Dropouts'],
            hideHover: 'auto'
        });

        //ST Discount Graph
        $('#stdiscount-total-dropouts').empty();
        var stdiscount = new Morris.Bar({
            element: 'stdiscount-total-dropouts',
            data: [
                {type: 'ND',value: getRandom()},
                {type: 'PD 80', value: getRandom()},
                {type: 'PD 60', value: getRandom()},
                {type: 'PD 33', value: getRandom()},
                {type: 'FD', value: getRandom()},
                {type: 'FD with Stipend', value: getRandom()},
            ],
            xkey: 'type',
            ykeys: ['value'],
            labels: ['Total Number of Dropouts'],
            hideHover: 'auto',
            barColors: ['#1cc09f']
        });

        //Units Graph
        $('#units-total-dropouts').empty();
        var units = new Morris.Bar({
            element: 'units-total-dropouts',
            data: [
                {type: 'Less than 15 Units',value: getRandom()},
                {type: '15 to 21 Units', value: getRandom()},
                {type: 'More than 21 Units', value: getRandom()}
            ],
            xkey: 'type',
            ykeys: ['value'],
            labels: ['Total Number of Dropouts'],
            hideHover: 'auto'
        });

        //Wasted Money
        var wastedRand = Math.floor(Math.random() * (800000 - 200000 + 1)) + 200000;
        $('#wasted-money').empty();
        $('#wasted-money').append('Php ' + wastedRand);

        //Average Years
        $('#average-years').empty();
        $('#average-years').append(Math.floor(Math.random() * (5.5 - 3.8 + 1)) + 3.8);
    }

    //Year Dropdown
    $('#year-dropdown').change(function() {
        var yearVal = $('#year-dropdown').val();

        if (yearVal != '') {
            $('#prediction-year').empty();
            $('#prediction-year').append(yearVal + ' ');
            showGraphs();
        }
    });

    //College Dropdown
    $('#college-dropdown').change(function() {
        var collegeVal = $('#college-dropdown').val();
        var select = document.getElementById('program-dropdown');

        //Program Dropdown Options
        if (collegeVal == 'College of Engineering') {
            while (select.firstChild) {
                select.removeChild(select.firstChild);
            }

            var option = document.createElement('option');
            option.appendChild(document.createTextNode('Choose Program'));
            option.value = '';
            select.appendChild(option);

            var option1 = document.createElement('option');
            option1.appendChild(document.createTextNode('All Programs'));
            option1.value = 'All Programs';
            select.appendChild(option1);

            var option2 = document.createElement('option');
            option2.appendChild(document.createTextNode('Chemical Engineering'));
            option2.value = 'Chemical Engineering';
            select.appendChild(option2);

            var option3 = document.createElement('option');
            option3.appendChild(document.createTextNode('Computer Engineering'));
            option3.value = 'Computer Engineering';
            select.appendChild(option3);

            var option4 = document.createElement('option');
            option4.appendChild(document.createTextNode('Computer Science'));
            option4.value = 'Computer Science';
            select.appendChild(option4);
        }

        else {
            while (select.firstChild) {
                select.removeChild(select.firstChild);
            }

            var option = document.createElement('option');
            option.appendChild(document.createTextNode('Choose Program'));
            option.value = '';
            select.appendChild(option);
        }

        if (collegeVal != '') {
            if ($('#year-dropdown').val() == '') {
                $('#modal').modal('show');
            }

            else {
                $('#prediction-program').empty();
                $('#prediction-college').empty();
                $('#prediction-college').append(collegeVal + ' ');
                showGraphs();
            }
        }
    });

    //Program Dropdown
    $('#program-dropdown').change(function() {
        var programVal = $('#program-dropdown').val();

        if (programVal != '') {
            $('#prediction-program').empty();
            $('#prediction-program').append(programVal + ' ');
            showGraphs();
        }
    });

</script>

@stop