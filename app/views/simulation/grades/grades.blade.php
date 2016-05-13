@extends('layouts/base')

{{-- Page title --}}
@section('title')

@parent
@stop

<!-- User Sidebar -->
@include('simulation/_simulation-sidebar')

{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Simulation of Attrition Using Grades
        </h1>
    </div>
</div>
<!-- /. ROW  -->

@if ($error)
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <strong>Invalid input.</strong> Sum of input values should be equal to 100%.
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            Get estimate of <strong>Average Attrition Rate</strong> from user-inputted student <strong>Grade Range</strong> percentages.
        </div>
    </div>
</div>

<!-- Grade Range Input -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Enter percentages of students for each Grade Range.
            </div>
            <div class="panel-body">
                {{Form::open(array('role' => 'form', 'action' => 'SimulationController@postGrades'))}}
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <div class="form-group input-group">
                                <input type="number" id="lineof1" name="lineof1" class="form-control" placeholder="1.00-1.99" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-group">
                                <input type="number" id="lineof2" name="lineof2" class="form-control" placeholder="2.00-2.99" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-group">
                                <input type="number" id="lineof3" name="lineof3" class="form-control" placeholder="3.00-3.99" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group input-group">
                                <input type="number" id="lineof4" name="lineof4" class="form-control" placeholder="4.00-5.00" style="height:100px">
                                <span class="input-group-addon" style="height:100px">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <center>
                            <button type="submit" class="btn btn-success" id="simulate">Simulate</button>
                        </center>
                    </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>

@stop

@section('javascript')

@stop