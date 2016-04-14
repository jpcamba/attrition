@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('correlation/_correlation-sidebar')

{{-- Page content --}}
@section('content')

<!-- start of page content -->
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Correlation of Factors <!--<small>Say something about this page</small>-->
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- Overall -->
<div class="row">
    <div class="col-md-12">
        <!-- Chart -->
        @include('correlation/_correlation-total')

        <!-- Explanation of Factors -->
        <div class="panel panel-primary">
            <div class="panel-heading"><h5>Explanation of Factors</h5></div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>Positive Correlation</th><th>Negative Correlation</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Employment</td> <td>High Grades</td></tr>
                            <tr><td>Low Grades</td> <td>Unemployment</td></tr>
                            <tr><td>ST Bracket</td> <td></td></tr>
                            <tr><td>Region</td> <td></td></tr>
                            <tr><td>Underloading Units</td> <td></td></tr>
                            <tr><td>Overloading Units</td> <td></td></tr>
                        </tbody>
                    </table>
                </div>
                <b>Positive Correlation: </b> An increase in this factor corresponds to an <b>increase</b> in attrition rate. <br>
                <b>Negative Correlation: </b> An increase in this factor corresponds to a <b>decrease</b> in attrition rate.
            </div>
        </div>
    </div>
</div>

<!-- College Section -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> <h3>College</h3></div>
            <div class="panel-body">
                <!-- Factor Dropdown -->
                <div class="input-group pull-right">
                    <label>Choose Factor</label>
                    <select class="form-control" id="college-factor-dropdown" name="college-factor-dropdown">
                        @foreach ($factors as $factor)
                            <option value={{$factor->factorid}}>{{$factor->factorname}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Factor Comparison Among Colleges -->
                <div id="college-factor" style="height:300px"></div><br><br>
                <center><h4 id="college-factorname"></h4></center>
                *A correlation value of 0 means that there is insufficient data for computing correlation for that factor.<br><br>
 
                <!-- College Dropdown -->
                <h4><b>View Correlation for Specific College</b></h4>
                {{ Form::open(array('action' => 'CorrelationController@showCollege')) }}
                  <div class="input-group">
                    <select class="form-control" required="required" id="college-dropdown" name="college-dropdown">
                        @foreach($colleges as $college){
                            <option value={{$college->unitid}}>{{$college->unitname}}</option>
                        }
                        @endforeach
                    </select>
                  </div>
                  <br/>
                  <button type="submit" class="btn btn-default">View College</button>
                {{ Form::close() }}
                <!-- end of dropdown -->
            </div>
        </div>
    </div>
</div>

<!-- Department Section -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"> <h3>Department</h3></div>
            <div class="panel-body">
                <!-- Factor Dropdown -->
                <div class="input-group pull-right">
                    <label>Choose Factor</label>
                    <select class="form-control" id="department-factor-dropdown" name="department-factor-dropdown">
                        @foreach ($factors as $factor)
                            <option value={{$factor->factorid}}>{{$factor->factorname}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Factor Comparison Among Departments -->
                <div id="department-factor" style="height:300px"></div><br><br>
                <center><h4 id="department-factorname"></h4></center>
                *A correlation value of 0 means that there is insufficient data for computing correlation for that factor.<br><br>
 
                <!-- Department Dropdown -->
                <h4><b>View Correlation for Specific Department</b></h4>
                {{ Form::open(array('action' => 'CorrelationController@showDepartment')) }}
                  <div class="input-group">
                    <select class="form-control" required="required" id="department-dropdown" name="department-dropdown">
                        @foreach($departments as $department){
                            <option value={{$department->unitid}}>{{$department->unitname}}</option>
                        }
                        @endforeach
                    </select>
                  </div>
                  <br/>
                  <button type="submit" class="btn btn-default">View Department</button>
                {{ Form::close() }}
                <!-- end of dropdown -->
            </div>
        </div>
    </div>
</div>

<!-- end content section -->

@stop
<!-- /. ROW  -->

@section('javascript')

@include('correlation/scripts/_correlation-total-scripts')

@stop
